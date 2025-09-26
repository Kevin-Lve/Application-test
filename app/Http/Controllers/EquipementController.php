<?php

namespace App\Http\Controllers;

use App\Http\Requests\Equipement\StoreEquipementRequest;
use App\Http\Requests\Equipement\UpdateEquipementRequest;
use App\Models\ActionMateriel;
use App\Models\Com\Reseau\Vlan;
use App\Models\Equipement\Categorie;
use App\Models\Equipement\Equipement;
use App\Models\Gestion\Emplacement;
use App\Models\Gestion\Service;
use App\Models\User;
use App\Services\Equipement\DynamicAttributeService;
use App\Services\Equipement\EquipmentHistoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EquipementController extends Controller
{
    public function __construct(
        private readonly DynamicAttributeService $dynamicAttributeService,
        private readonly EquipmentHistoryService $historyService,
    ) {
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 20);

        $equipements = Equipement::query()
            ->with(['emplacement', 'sous_categorie', 'vlan', 'action'])
            ->when($search, function ($query, $search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('numero_serie', 'like', "%{$search}%")
                        ->orWhere('hostname', 'like', "%{$search}%")
                        ->orWhere('adresse_ip', 'like', "%{$search}%")
                        ->orWhere('adresse_mac', 'like', "%{$search}%");
                })
                    ->orWhereHas('sous_categorie', fn ($q) => $q->where('nom', 'like', "%{$search}%"))
                    ->orWhereHas('emplacement', fn ($q) => $q->where('nom', 'like', "%{$search}%"));
            })
            ->latest('created_at')
            ->paginate($perPage)
            ->withQueryString();

        return view('it.equipement.index', [
            'equipements' => $equipements,
            'search' => $search,
        ]);
    }

    public function create_show(Request $request)
    {
        $categories = Categorie::with('sousCategories')->orderBy('nom')->get();
        $selectedCategoryId = $request->old('id_categorie') ?? $categories->first()?->id;
        $selectedSousCategorieId = $request->old('id_sous_categorie');

        if (!$selectedSousCategorieId && $selectedCategoryId) {
            $selectedSousCategorieId = $categories
                ->firstWhere('id', $selectedCategoryId)?
                ->sousCategories
                ->first()
                ?->id;
        }

        $selectedService = $request->old('id_service') ? Service::find($request->old('id_service')) : null;
        $selectedUser = $request->old('id_utilisateur') ? User::find($request->old('id_utilisateur')) : null;

        return view('it.equipement.ajoute', [
            'categories' => $categories,
            'emplacements' => Emplacement::orderBy('nom')->get(),
            'vlans' => Vlan::orderBy('nom')->get(),
            'actions' => ActionMateriel::orderBy('nom')->get(),
            'selectedCategoryId' => $selectedCategoryId,
            'selectedSousCategorieId' => $selectedSousCategorieId,
            'selectedServiceId' => $selectedService?->id,
            'selectedServiceLabel' => $selectedService?->nom,
            'selectedUserId' => $selectedUser?->id,
            'selectedUserLabel' => $selectedUser ? trim($selectedUser->prenom . ' ' . $selectedUser->nom) : null,
        ]);
    }

    public function create_equipement(StoreEquipementRequest $request)
    {
        $equipement = DB::transaction(function () use ($request) {
            $equipement = Equipement::create($request->toEquipmentData());
            $equipement->load('attributsValeurs');

            $attributeChanges = $this->dynamicAttributeService->sync($equipement, $request->dynamicAttributes());

            $this->historyService->logCreation(
                $equipement,
                Auth::id(),
                $attributeChanges,
                $request->commentaire()
            );

            return $equipement;
        });

        return redirect()->route('it.equipement.show', ['id' => $equipement->id])
            ->with('success', "Équipement créé avec succès.");
    }

    public function show_equipement($id)
    {
        $equipement = Equipement::with(['sous_categorie.categorie', 'sous_categorie.attributs', 'action', 'historiques'])
            ->findOrFail($id);

        return view('it.equipement.afficher', [
            'equipement' => $equipement,
        ]);
    }

    public function supprimer_equipement($id)
    {
        $equipement = Equipement::findOrFail($id);
        $equipement->delete();

        return redirect()->route('equipement.show.index')
            ->with('success', "Équipement supprimé avec succès.");
    }

    public function edit_show($id, Request $request)
    {
        $equipement = Equipement::with(['attributsValeurs', 'sous_categorie'])->findOrFail($id);

        $categories = Categorie::with('sousCategories')->orderBy('nom')->get();
        $selectedCategoryId = $request->old('id_categorie') ?? $equipement->sous_categorie?->id_categorie;
        $selectedSousCategorieId = $request->old('id_sous_categorie') ?? $equipement->id_sous_categorie;

        if (!$selectedSousCategorieId && $selectedCategoryId) {
            $selectedSousCategorieId = $categories
                ->firstWhere('id', $selectedCategoryId)?
                ->sousCategories
                ->first()
                ?->id;
        }

        $selectedService = $request->old('id_service')
            ? Service::find($request->old('id_service'))
            : ($equipement->type_attribution === 'service' && $equipement->id_attribution
                ? Service::find($equipement->id_attribution)
                : null);

        $selectedUser = $request->old('id_utilisateur')
            ? User::find($request->old('id_utilisateur'))
            : ($equipement->type_attribution === 'utilisateur' && $equipement->id_attribution
                ? User::find($equipement->id_attribution)
                : null);

        $existingAttributes = $equipement->attributsValeurs
            ->mapWithKeys(fn ($valeur) => [$valeur->id_attribut => $valeur->valeur])
            ->toArray();

        return view('it.equipement.modifier', [
            'categories' => $categories,
            'emplacements' => Emplacement::orderBy('nom')->get(),
            'vlans' => Vlan::orderBy('nom')->get(),
            'actions' => ActionMateriel::orderBy('nom')->get(),
            'equipement' => $equipement,
            'selectedCategoryId' => $selectedCategoryId,
            'selectedSousCategorieId' => $selectedSousCategorieId,
            'selectedServiceId' => $selectedService?->id,
            'selectedServiceLabel' => $selectedService?->nom,
            'selectedUserId' => $selectedUser?->id,
            'selectedUserLabel' => $selectedUser ? trim($selectedUser->prenom . ' ' . $selectedUser->nom) : null,
            'existingAttributeValues' => $existingAttributes,
        ]);
    }

    public function edit($id, UpdateEquipementRequest $request)
    {
        $equipement = Equipement::with('attributsValeurs')->findOrFail($id);

        DB::transaction(function () use ($equipement, $request) {
            $before = $equipement->getAttributes();
            $payload = $request->toEquipmentData();

            $equipement->fill($payload);
            if ($equipement->isDirty()) {
                $equipement->save();
            }

            $equipement->load('attributsValeurs');
            $attributeChanges = $this->dynamicAttributeService->sync($equipement, $request->dynamicAttributes());

            $fieldChanges = $this->historyService->buildFieldChanges($equipement, $before, $payload);

            $this->historyService->logUpdate(
                $equipement,
                Auth::id(),
                $fieldChanges,
                $attributeChanges,
                $request->commentaire()
            );
        });

        return redirect()->route('it.equipement.show', ['id' => $equipement->id])
            ->with('success', "Équipement mis à jour avec succès.");
    }
}
