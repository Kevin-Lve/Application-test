<?php

namespace App\Services\Equipement;

use App\Models\Equipement\Equipement;
use App\Models\Equipement\HistoriqueEquipement;
use Illuminate\Support\Arr;

class EquipmentHistoryService
{
    public function logCreation(Equipement $equipement, ?int $userId, array $attributeChanges = [], ?string $comment = null): void
    {
        $this->storeLog($equipement, $userId, 'create', [
            'champs' => $this->formatBaseAttributes($equipement->getAttributes()),
            'attributs_dynamiques' => $attributeChanges,
            'commentaire' => $comment,
        ]);
    }

    public function logUpdate(Equipement $equipement, ?int $userId, array $fieldChanges, array $attributeChanges, ?string $comment): void
    {
        if (empty($fieldChanges) && empty($attributeChanges)) {
            return;
        }

        $this->storeLog($equipement, $userId, 'update', [
            'champs' => $fieldChanges,
            'attributs_dynamiques' => $attributeChanges,
            'commentaire' => $comment,
        ]);
    }

    public function buildFieldChanges(Equipement $equipement, array $before, array $after): array
    {
        $changes = [];

        foreach ($after as $field => $value) {
            $previous = $before[$field] ?? null;
            if ($previous != $value) {
                $changes[$field] = [
                    'before' => $previous,
                    'after' => $value,
                ];
            }
        }

        return $changes;
    }

    private function storeLog(Equipement $equipement, ?int $userId, string $type, array $payload): void
    {
        HistoriqueEquipement::create([
            'id_equipement' => $equipement->id,
            'id_utilisateur' => $userId,
            'id_action' => $equipement->id_action,
            'description' => json_encode([
                'type_action' => $type,
                'donnees' => $payload,
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
        ]);
    }

    private function formatBaseAttributes(array $attributes): array
    {
        return Arr::only($attributes, [
            'hostname',
            'numero_serie',
            'adresse_ip',
            'adresse_mac',
            'prix',
            'date_achat',
            'date_obsolescence',
            'date_livraison',
            'type_attribution',
            'id_attribution',
            'id_action',
            'id_emplacement',
            'id_vlan',
        ]);
    }
}
