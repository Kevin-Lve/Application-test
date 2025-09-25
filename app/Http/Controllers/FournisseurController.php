<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fournisseur;
use App\Models\Equipement\Equipement;

class FournisseurController extends Controller
{
    /**
     * Liste des fournisseurs avec recherche & pagination
     */
    public function index(Request $request)
    {
        $search  = trim((string) $request->input('search', ''));
        $perPage = (int) $request->input('perPage', 5);

        $query = Fournisseur::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        $fournisseurs = $query->orderBy('nom')
                              ->paginate($perPage)
                              ->withQueryString();

        return view('it.fournisseur.index', [
            'fournisseurs' => $fournisseurs,
            'search'       => $search,
            'perPage'      => $perPage,
        ]);
    }

    public function create_show()
    {
        return view('it.fournisseur.ajouter');
    }

    /**
     * Création d'un fournisseur (avec image optionnelle)
     */
    public function create(Request $request)
    {
        $request->validate([
            'nom_fournisseur' => ['required', 'string', 'max:255'],
            'photo'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $path = null;
        if ($request->hasFile('photo')) {
            // Disque "photo_fournisseur" déclaré dans config/filesystems.php
            $path = $request->file('photo')->store('', 'photo_fournisseur');
        }

        Fournisseur::create([
            'nom'   => $request->input('nom_fournisseur'),
            'image' => $path,
        ]);

        return redirect()->route('fournisseur.show.index')->with('success', 'Fournisseur créé.');
    }

    /**
     * Suppression d'un fournisseur
     */
    public function supprimer_fournisseur($id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->delete();

        return redirect()->route('fournisseur.show.index')->with('success', 'Fournisseur supprimé.');
    }

    /**
     * Afficher un fournisseur : fiche + KPIs + liste paginée des équipements
     * Recherche multi-champs ; le "status" est cherché via action.nom (pas de colonne statut/libelle).
     */
    public function show_fournisseur($id, Request $request)
    {
        $perPage = (int) $request->input('perPage', 10);
        $search  = trim((string) $request->input('search', ''));

        // Fiche fournisseur
        $fournisseur = Fournisseur::findOrFail($id);

        // Base query: équipements dont la sous_categorie -> id_fournisseur = $id
        $query = Equipement::with([
                'sous_categorie',
                'sous_categorie.fournisseur',
                'emplacement',
                'vlan',
                'action', // "status" métier
            ])
            ->whereHas('sous_categorie', function ($q) use ($id) {
                $q->where('id_fournisseur', $id);
            });

        // Recherche multi-champs (TOUT regroupé sous le fournisseur)
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                // Champs directs
                $q->where(function ($qq) use ($search) {
                    $qq->where('hostname', 'like', "%{$search}%")
                       ->orWhere('numero_serie', 'like', "%{$search}%")
                       ->orWhere('adresse_ip', 'like', "%{$search}%")
                       ->orWhere('adresse_mac', 'like', "%{$search}%");
                });
                // Relations
                $q->orWhereHas('sous_categorie', function ($qq) use ($search) {
                    $qq->where('nom', 'like', "%{$search}%");
                });
                $q->orWhereHas('emplacement', function ($qq) use ($search) {
                    $qq->where('nom', 'like', "%{$search}%");
                });
                // "Status" via ActionMateriel (champ nom)
                $q->orWhereHas('action', function ($qq) use ($search) {
                    $qq->where('nom', 'like', "%{$search}%");
                });
            });
        }

        // Pagination + conservation des paramètres
        $equipements = $query->orderByDesc('id')
                             ->paginate($perPage)
                             ->onEachSide(1)
                             ->withQueryString();

        // KPIs (calculés côté DB)
        $nb_equipements_total = Equipement::whereHas('sous_categorie', fn($q) => $q->where('id_fournisseur', $id))->count();
        $valeur_totale        = Equipement::whereHas('sous_categorie', fn($q) => $q->where('id_fournisseur', $id))->sum('prix');
        $nb_sous_categories   = Equipement::whereHas('sous_categorie', fn($q) => $q->where('id_fournisseur', $id))
                                          ->distinct('id_sous_categorie')
                                          ->count('id_sous_categorie');
        $dernier_attribue     = optional(
            Equipement::whereHas('sous_categorie', fn($q) => $q->where('id_fournisseur', $id))
                      ->latest('created_at')
                      ->first()
        )->created_at;

        return view('it.fournisseur.show_one_fournisseur', [
            'fournisseur'          => $fournisseur,
            'equipements'          => $equipements,
            'search'               => $search,
            'perPage'              => $perPage,
            'nb_equipements_total' => $nb_equipements_total,
            'valeur_totale'        => $valeur_totale,
            'nb_sous_categories'   => $nb_sous_categories,
            'dernier_attribue'     => $dernier_attribue,
        ]);
    }
}
