<?php

namespace App\Http\Controllers;

use App\Models\Equipement\Equipement;
use App\Models\Equipement\HistoriqueEquipement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Affichage du tableau de bord principal
    public function show_dashboard()
    {
        $totalEquipements = Equipement::count();

        $statusBreakdown = Equipement::select('id_action', DB::raw('COUNT(*) as total'))
            ->with('action:id,nom')
            ->groupBy('id_action')
            ->orderByDesc('total')
            ->get();

        $topSousCategories = Equipement::select('id_sous_categorie', DB::raw('COUNT(*) as total'))
            ->with('sous_categorie:id,nom')
            ->groupBy('id_sous_categorie')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $attributionCounts = Equipement::select('type_attribution', DB::raw('COUNT(*) as total'))
            ->groupBy('type_attribution')
            ->pluck('total', 'type_attribution');

        $recentLogs = HistoriqueEquipement::with('equipement:id,hostname,numero_serie')
            ->latest('created_at')
            ->limit(8)
            ->get();

        $monthlyEvolution = DB::table('equipement')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->whereNotNull('created_at')
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $chartData = [
            'statusBreakdown' => $statusBreakdown->map(fn ($row) => [
                'label' => $row->action->nom ?? 'Non défini',
                'value' => (int) $row->total,
            ])->values(),
            'monthlyEvolution' => $monthlyEvolution->map(fn ($row) => [
                'label' => $row->month,
                'value' => (int) $row->total,
            ])->values(),
            'categoryTop' => $topSousCategories->map(fn ($row) => [
                'label' => optional($row->sous_categorie)->nom ?? 'Non défini',
                'value' => (int) $row->total,
            ])->values(),
        ];

        $kpis = [
            'totalEquipements' => $totalEquipements,
            'attribuesUtilisateurs' => (int) ($attributionCounts['utilisateur'] ?? 0),
            'attribuesServices' => (int) ($attributionCounts['service'] ?? 0),
            'enStock' => (int) ($attributionCounts['stock'] ?? 0),
        ];

        return view('dashboard', [
            'kpis' => $kpis,
            'statusBreakdown' => $statusBreakdown,
            'topSousCategories' => $topSousCategories,
            'attributionCounts' => $attributionCounts,
            'recentLogs' => $recentLogs,
            'chartData' => $chartData,
            'totalEquipements' => $totalEquipements,
        ]);
    }

    //****** Vues pour le Superviseur ******

    // Gestion des Demandes
    public function show_creation_demande()
    {
        return view("superviseur/demande/creer-demande");
    }

    public function show_demande()
    {
        return view("superviseur/demande/gestion-demande");
    }

    // Gestion des Services et Utilisateurs
    public function show_creation_utilisateur()
    {
        return view("superviseur/service/ajouter-utilisateur");
    }

    public function show_modifier_utilisateur()
    {
        return view("superviseur/service/modifier-utilisateur");
    }

    public function show_service()
    {
        return view("superviseur/service/gestion-service");
    }

    //****** Vues pour l'Équipe IT ******

    // Gestion des Documents
    public function show_document()
    {
        return view("it/gestion/document/gestion-document");
    }

    public function show_ajouter_document()
    {
        return view("it/gestion/document/ajouter-document");
    }

    // Gestion des Fournisseurs
    public function show_fournisseur()
    {
        return view("it/gestion/fournisseur/gestion-fournisseur");
    }

    public function show_ajouter_fournisseur()
    {
        return view("it/gestion/fournisseur/ajouter-fournisseur");
    }

    public function show_modifier_fournisseur()
    {
        return view("it/gestion/fournisseur/modifier-fournisseur");
    }

    // Gestion des Demandes IT
    public function show_demande_it()
    {
        return view("it/gestion/demande/demande-it");
    }

    // Gestion des Équipements IT
    public function show_ajouter_equipement()
    {
        return view("it/gestion/equipement/ajouter-equipement");
    }

    public function show_ajouter_categorie()
    {
        return view("it/gestion/equipement/ajouter-categorie");
    }

    public function show_ajouter_sous_categorie()
    {
        return view("it/gestion/equipement/ajouter-sous-categorie");
    }

    // public function show_attribuer_equipement()
    // {
    //     return view("it/gestion/equipement/attribuer-equipement");
    // }

    public function show_inventaire()
    {
        return view("it/gestion/equipement/gestion-equipement");
    }

    // Gestion des Utilisateurs IT
    public function show_consulter_utilisateur_it()
    {
        return view("it/gestion/utilisateur/consulter-utilisateur");
    }

    public function show_ajouter_utilisateur_it()
    {
        return view("it/gestion/utilisateur/ajouter-utilisateur");
    }

    public function show_modifier_utilisateur_it()
    {
        return view("it/gestion/utilisateur/modifier-utilisateur");
    }
}
