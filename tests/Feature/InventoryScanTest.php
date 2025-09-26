<?php

namespace Tests\Feature;

use App\Models\Consommable;
use App\Models\Equipement\Equipement;
use App\Models\Gestion\Service;
use App\Models\Permission\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryScanTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): User
    {
        $service = Service::create(['nom' => 'IT']);
        $role = Role::create(['nom' => 'admin']);

        $user = User::create([
            'prenom' => 'Kevin',
            'nom' => 'Ops',
            'email' => 'kevin@example.test',
            'password' => bcrypt('password'),
            'id_service' => $service->id,
            'id_role' => $role->id,
        ]);

        $this->actingAs($user);

        return $user;
    }

    public function test_scan_redirects_to_equipment_edit_when_single_result(): void
    {
        $this->actingAsAdmin();

        $equipement = Equipement::create([
            'hostname' => 'PC-42',
            'numero_serie' => 'SN-UNIQUE-001',
        ]);

        $response = $this->post(route('equipement.scan.search'), [
            'code' => 'SN-UNIQUE-001',
        ]);

        $response->assertRedirect(route('equipement.edit.show', $equipement->id));
    }

    public function test_scan_shows_choice_view_when_multiple_matches(): void
    {
        $this->actingAsAdmin();

        Equipement::create([
            'hostname' => 'PC-1',
            'numero_serie' => 'DUPLI-123',
        ]);

        Consommable::create([
            'nom' => 'Cable RJ45',
            'code_barre' => 'DUPLI-123',
            'quantite_stock' => 5,
        ]);

        $response = $this->post(route('equipement.scan.search'), [
            'code' => 'DUPLI-123',
        ]);

        $response->assertOk();
        $response->assertViewIs('it.equipement.scan-result');
        $response->assertViewHas('equipements');
        $response->assertViewHas('consommables');
    }

    public function test_scan_redirects_to_consommable_when_only_consumable_matches(): void
    {
        $this->actingAsAdmin();

        $consommable = Consommable::create([
            'nom' => 'Chargeur USB-C',
            'code_barre' => 'CHG-999',
            'quantite_stock' => 3,
        ]);

        $response = $this->post(route('equipement.scan.search'), [
            'code' => 'CHG-999',
        ]);

        $response->assertRedirect(route('consommables.edit', $consommable));
    }
}
