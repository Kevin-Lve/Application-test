<?php 

use App\Http\Controllers\CategorieController;

Route::prefix('categorie')->group(function () {

    // *************             Categorie ********************** 

    Route::get('/', [CategorieController::class, 'index'])->name('categorie.show.index');
    Route::get('/ajouter', [CategorieController::class, 'create_show'])->name('categorie.create.show');
    Route::post('/ajouter', [CategorieController::class, 'create'])->name('categorie.create');


    //Supprimer 
    Route::get('/suprrimer/{id}',[CategorieController::class, 'supprimer_categorie'])->name('categorie.supprimer');


    // Visualiser Catégorie
    Route::get('/afficher/{id}',[CategorieController::class,'show_categorie'])->name('it.categorie.show');






    // *************      Sous Catégorie ************


    Route::get('/souscategorie/ajouter/',[CategorieController::class, 'create_subcategory_show'])->name('categorie.subcategory.create.show');
    Route::get('/souscategorie/{id_categorie}', [CategorieController::class, 'subcategorie_index'])->name('categorie.subcategorie.show');
    Route::post('/souscategorie/ajouter', [CategorieController::class, 'create_subcategory'])->name('categorie.subcategorie.create');

    //Supprimer 
    Route::get('/suprrimer/sous-categorie/{id}',[CategorieController::class, 'supprimer_sous_categorie'])->name('sous_categorie.supprimer');


     // Visualiser Sous-Catégorie
     Route::get('/afficher/sous-categorie/{id}',[CategorieController::class,'show_sous_categorie'])->name('it.sous_categorie.show');

     //modifier - valider modification
     Route::get('/sous_categorie/modifer/{id}', [CategorieController::class, 'edit_show_sous_categorie'])->name('sous_categorie.show');
     Route::post('/sous_categorie/modifer/{id}', [CategorieController::class, 'edit_sous_categorie'])->name('sous_categorie.edit');


    
});
