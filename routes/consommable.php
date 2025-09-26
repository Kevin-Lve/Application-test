<?php

use App\Http\Controllers\ConsommableController;
use Illuminate\Support\Facades\Route;

Route::prefix('consommables')->group(function () {
    Route::get('/', [ConsommableController::class, 'index'])->name('consommables.index');
    Route::get('/ajouter', [ConsommableController::class, 'create'])->name('consommables.create');
    Route::post('/ajouter', [ConsommableController::class, 'store'])->name('consommables.store');
    Route::get('/{consommable}/modifier', [ConsommableController::class, 'edit'])->name('consommables.edit');
    Route::put('/{consommable}', [ConsommableController::class, 'update'])->name('consommables.update');
    Route::post('/{consommable}/adjust', [ConsommableController::class, 'adjust'])->name('consommables.adjust');
});
