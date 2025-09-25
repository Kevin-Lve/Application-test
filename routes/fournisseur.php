<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FournisseurController;


Route::prefix('fournisseur')->group(function () {
    Route::get('/', [FournisseurController::class, 'index'])->name('fournisseur.show.index');

    Route::get('/ajouter', [FournisseurController::class, 'create_show'])->name('fournisseur.create.show');
    Route::post('/ajouter', [FournisseurController::class, 'create'])->name('fournisseur.create');

    // Supprimer Fournisseur 
    Route::get('supprimer/{id}',[FournisseurController::class,'supprimer_fournisseur'])->name('fournisseur.supprimer');

    // Visualiser Fournisseur 
    Route::get('/afficher/{id}',[FournisseurController::class, 'show_fournisseur'])->name('it.fournisseur.show');
 });
