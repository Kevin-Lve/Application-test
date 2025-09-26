<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\InventoryScanController;

Route::prefix('equipement')->group(function () {
    Route::get('/scan', [InventoryScanController::class, 'show'])->name('equipement.scan');
    Route::post('/scan', [InventoryScanController::class, 'search'])->name('equipement.scan.search');

    Route::get('/', [EquipementController::class, 'index'])->name('equipement.show.index');

    Route::get('/afficher/{id}', [EquipementController::class, 'show_equipement'])->name('it.equipement.show');

    Route::get('/modifier/{id}', [EquipementController::class, 'edit_show'])->name('equipement.edit.show');
    Route::post('/modifier/{id}', [EquipementController::class, 'edit'])->name('equipement.edit');

    Route::get('/ajouter', [EquipementController::class, 'create_show'])->name('equipement.create.show');
    Route::post('/ajouter', [EquipementController::class, 'create_equipement'])->name('equipement.create');

    // Route::get('/modifier', [EquipementController::class, 'create_show'])->name('equipement.create.show');
    // Route::post('/modifier', [EquipementController::class, 'modifier_equipement'])->name('equipement.modifier');

    //Supprimer equipement 
    Route::get('/supprimer/{id}', [EquipementController::class, 'supprimer_equipement'])->name('equipement.supprimer');

    //Test formulaire équipement 
    Route::get('/test-formulaire', function() {
        return view('it.equipement.test-equipement');
    });


 });
