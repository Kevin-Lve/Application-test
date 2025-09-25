<?php 

use App\Http\Controllers\UserController;

Route::prefix('user')->group(function () {

    

    Route::get('/', [UserController::class, 'index'])->name('user.show.index');

    Route::get('/afficher/{id}', [UserController::class, 'show_utilisateur'])->name('it.utilisateur.show');
    
    Route::get('/ajouter', [UserController::class, 'create_show'])->name('user.create.show');
    Route::post('/ajouter', [UserController::class, 'create'])->name('user.create');

    //Supprimer Utilisateur 
    Route::get('/supprimer/{id}',[UserController::class,'supprimer_utilisateur'])->name('user.supprimer');


});
