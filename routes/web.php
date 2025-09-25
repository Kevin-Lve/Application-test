<?php

use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MotDePassOublieController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Routes pour les utilisateurs invités (non authentifiés)
Route::middleware('guest')->group(function () {
    // Page de connexion
    Route::get('/login', [AuthentificationController::class, 'show_login'])->name('login');
    // Action de connexion
    Route::post('/login', [AuthentificationController::class, 'login'])->name('login.make');
    // Mot de passe oublié
    Route::get('/mtp', [MotDePassOublieController::class, 'show_forgot'])->name('forgot.show');
});



// Routes pour les utilisateurs authentifiés
Route::middleware('auth')->group(function () {
    // Tableau de bord principal
    Route::get('/dashboard', [DashboardController::class, 'show_dashboard'])->name('dashboard.show');
    // Déconnexion
    Route::get('/logout', [AuthentificationController::class, 'logout'])->name('logout');

    //****** Routes pour le Superviseur ******
    Route::prefix('superviseur')->group(function () {
        // Gestion des Demandes
        Route::get('/demande/creer', [DashboardController::class, 'show_creation_demande'])->name('superviseur.demande.creer');
        Route::get('/demande', [DashboardController::class, 'show_demande'])->name('superviseur.demande.gestion');
    });

    include 'service.php';
    include 'emplacement.php';
    include 'fournisseur.php';
    include 'vlan.php';
    include 'categorie.php';
    include 'user.php';
    include 'equipement.php';
    

    //****** Routes pour l'Équipe IT ******
    Route::prefix('it')->group(function () {
        // Gestion des Documents
        Route::get('/document', [DashboardController::class, 'show_document'])->name('it.document.gestion');
        Route::get('/document/ajouter', [DashboardController::class, 'show_ajouter_document'])->name('it.document.ajouter');

        // Gestion des Fournisseurs
        Route::get('/fournisseur', [DashboardController::class, 'show_fournisseur'])->name('it.fournisseur.gestion');
        Route::get('/fournisseur/ajouter', [DashboardController::class, 'show_ajouter_fournisseur'])->name('it.fournisseur.ajouter');
        Route::get('/fournisseur/modifier', [DashboardController::class, 'show_modifier_fournisseur'])->name('it.fournisseur.modifier');

        // Gestion des Demandes IT
        Route::get('/gestion/demande', [DashboardController::class, 'show_demande_it'])->name('it.demande.gestion');

        // Gestion des Équipements IT
        // Route::prefix('equipement')->group(function () {
        //     Route::get('/ajouter', [DashboardController::class, 'show_ajouter_equipement'])->name('it.equipement.ajouter');
        //     Route::get('/ajouter-categorie', [DashboardController::class, 'show_ajouter_categorie'])->name('it.categorie.ajouter');
        //     Route::get('/ajouter-sous-categorie', [DashboardController::class, 'show_ajouter_sous_categorie'])->name('it.sous-categorie.ajouter');
        //     Route::get('/attribuer', [DashboardController::class, 'show_attribuer_equipement'])->name('it.equipement.attribuer');
        //     Route::get('/inventaire', [DashboardController::class, 'show_inventaire'])->name('it.equipement.inventaire');
        // });

        // Gestion des Utilisateurs IT
        Route::prefix('utilisateur')->group(function () {
            Route::get('/consulter', [DashboardController::class, 'show_consulter_utilisateur_it'])->name('it.utilisateur.consulter');
            Route::get('/ajouter', [DashboardController::class, 'show_ajouter_utilisateur_it'])->name('it.utilisateur.ajouter');
            Route::get('/modifier', [DashboardController::class, 'show_modifier_utilisateur_it'])->name('it.utilisateur.modifier');
        });
    });
});