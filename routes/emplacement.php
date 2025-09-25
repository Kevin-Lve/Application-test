<?php 

use App\Http\Controllers\EmplacementController;
use App\Http\Controllers\FournisseurController;
use App\Models\Fournisseur;

Route::prefix('emplacement')->group(function () {
    Route::get('/', [EmplacementController::class, 'index'])->name('emplacement.show.index');
    Route::get('/ajouter', [EmplacementController::class, 'create_show'])->name('emplacement.create.show');
    Route::post('/ajouter', [EmplacementController::class, 'create'])->name('emplacement.create');

    Route::get('/supprimer/{id}',[EmplacementController::class, 'supprimer_emplacement'])->name('emplacement.supprimer');

    Route::get('/afficher/{id}',[EmplacementController::class, 'show_emplacement'])->name('it.emplacement.show');
});
