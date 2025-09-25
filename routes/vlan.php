<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VlanController;


Route::prefix('vlan')->group(function () {
    Route::get('/', [VlanController::class, 'index'])->name('vlan.show.index');

    Route::get('/ajouter', [VlanController::class, 'create_show'])->name('vlan.create.show');
    Route::post('/ajouter', [VlanController::class, 'create'])->name('vlan.create');

    //Supprimer Vlan 
    Route::get('/supprimer/{id}',[VlanController::class, 'supprimer_vlan'])->name('vlan.supprimer');

    //Visualiser Vlan 
    Route::get('/afficher/{id}',[VlanController::class,'show_vlan'])->name('it.vlan.show');
 });
