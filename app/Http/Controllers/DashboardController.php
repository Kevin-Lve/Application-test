<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Affichage du tableau de bord principal
    public function show_dashboard()
    {
        return view("dashboard");
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
