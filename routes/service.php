<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;


Route::prefix('service')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('service.show.index');

    Route::get('/afficher/{id}/service', [ServiceController::class, 'show_service'])->name('it.service.show');

    Route::get('/ajouter', [ServiceController::class, 'create_show'])->name('service.create.show');
    Route::post('/ajouter', [ServiceController::class, 'create'])->name('service.create');

    // Supprimer Service 
    Route::get('/supprimer/{id}',[ServiceController::class,'supprimer_service'])->name('supprimer.service');
 });
