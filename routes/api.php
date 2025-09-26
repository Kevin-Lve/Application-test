<?php

use App\Http\Controllers\Api\InventoryLookupController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/categories/{categorie}/sous-categories', [InventoryLookupController::class, 'sousCategories'])
        ->name('api.categories.sous-categories');

    Route::get('/sous-categories/{sousCategorie}/attributs', [InventoryLookupController::class, 'attributs'])
        ->name('api.sous-categories.attributs');

    Route::get('/search/users', [InventoryLookupController::class, 'searchUsers'])
        ->name('api.search.users');

    Route::get('/search/services', [InventoryLookupController::class, 'searchServices'])
        ->name('api.search.services');

    Route::get('/search/emplacements', [InventoryLookupController::class, 'searchEmplacements'])
        ->name('api.search.emplacements');
});
