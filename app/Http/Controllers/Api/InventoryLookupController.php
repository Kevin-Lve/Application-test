<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipement\Categorie;
use App\Models\Equipement\Sous_Categorie;
use App\Models\Equipement\SousCategorieAttribut;
use App\Models\Gestion\Emplacement;
use App\Models\Gestion\Service;
use App\Models\User;
use Illuminate\Http\Request;

class InventoryLookupController extends Controller
{
    public function sousCategories(Categorie $categorie)
    {
        $sousCategories = $categorie->sousCategories()
            ->select('id', 'nom', 'id_categorie')
            ->orderBy('nom')
            ->get()
            ->map(function (Sous_Categorie $sousCategorie) {
                return [
                    'id' => $sousCategorie->id,
                    'label' => $sousCategorie->nom,
                ];
            });

        // Kevin: je renvoie un tableau léger pour hydrater le select côté JS sans charger toute la catégorie.
        return response()->json(['data' => $sousCategories]);
    }

    public function attributs(Sous_Categorie $sousCategorie)
    {
        $attributs = $sousCategorie->attributs()
            ->select('id', 'nom_attribut', 'type', 'options', 'obligatoire')
            ->orderBy('nom_attribut')
            ->get()
            ->map(function (SousCategorieAttribut $attribut) {
                return [
                    'id' => $attribut->id,
                    'label' => $attribut->nom_attribut,
                    'type' => $attribut->type,
                    'options' => $attribut->options ?? [],
                    'required' => $attribut->obligatoire,
                ];
            });

        // Kevin: on reste en JSON simple pour générer les bons champs dynamiques via Vite.
        return response()->json(['data' => $attributs]);
    }

    public function searchUsers(Request $request)
    {
        $query = (string) $request->query('query', '');

        $users = User::query()
            ->select('id', 'prenom', 'nom', 'email')
            ->when($query, function ($builder) use ($query) {
                $like = '%' . $query . '%';
                $builder->where('prenom', 'like', $like)
                    ->orWhere('nom', 'like', $like)
                    ->orWhere('email', 'like', $like);
            })
            ->orderBy('prenom')
            ->limit(10)
            ->get()
            ->map(function (User $user) {
                return [
                    'id' => $user->id,
                    'label' => trim($user->prenom . ' ' . $user->nom),
                    'description' => $user->email,
                ];
            });

        // Kevin: autocomplete doit rester véloce, d'où la limite et la sélection light.
        return response()->json(['data' => $users]);
    }

    public function searchServices(Request $request)
    {
        $query = (string) $request->query('query', '');

        $services = Service::query()
            ->select('id', 'nom')
            ->when($query, function ($builder) use ($query) {
                $builder->where('nom', 'like', '%' . $query . '%');
            })
            ->orderBy('nom')
            ->limit(10)
            ->get()
            ->map(function (Service $service) {
                return [
                    'id' => $service->id,
                    'label' => $service->nom,
                ];
            });

        return response()->json(['data' => $services]);
    }

    public function searchEmplacements(Request $request)
    {
        $query = (string) $request->query('query', '');

        $emplacements = Emplacement::query()
            ->select('id', 'nom')
            ->when($query, function ($builder) use ($query) {
                $builder->where('nom', 'like', '%' . $query . '%');
            })
            ->orderBy('nom')
            ->limit(10)
            ->get()
            ->map(function (Emplacement $emplacement) {
                return [
                    'id' => $emplacement->id,
                    'label' => $emplacement->nom,
                ];
            });

        return response()->json(['data' => $emplacements]);
    }
}
