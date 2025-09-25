<?php

namespace App\Http\Controllers;

use App\Models\Equipement\Equipement;
use Illuminate\Http\Request;
use App\Models\Fournisseur;
use App\Models\Equipement\Categorie;
use App\Models\Equipement\Sous_Categorie;


class CategorieController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // Récupération du mot-clé de recherche
        $perPage = $request->input('perPage', 5); // Pagination configurable
    
        $categories = Categorie::query()
            ->when($search, function ($query, $search) {
                $query->where('nom', 'like', "%{$search}%"); // Recherche par nom de la catégorie
            })
            ->paginate($perPage);
    
        return view('it.categorie.index', [
            'categories' => $categories,
            'search' => $search, // Pour conserver la valeur dans le champ
        ]);
    }
    
    public function create_show()
    {
        return view('it.categorie.ajouter');
    }

    public function create()
    {
        Categorie::create([
            'nom' => request()->nom_categorie
        ]);

        return redirect()->route('categorie.show.index');
    }

    public function supprimer_categorie($id)
    {
        $categorie = Categorie::findOrFail($id); 
        $categorie->delete();
        return redirect()->route('categorie.show.index');
    }


    //Afficher Catégorie 
    public function show_categorie($id)
    {
        $categorie = Categorie::where('id',$id)->first();
        return view("it/categorie/show_one_categorie", [
            'categorie' => $categorie
        ]);
    }

    public function subcategorie_index($id_categorie)
    {
        $perPage = request('perPage', 5);        
        $subcategories = Sous_Categorie::where('id_categorie', $id_categorie)->with('fournisseur', 'categorie')->paginate($perPage);
        return view('it.categorie.subcategorie.index', [
            'subcategories' => $subcategories
        ]);
    }

    public function create_subcategory_show() 
    {
     $fournisseurs = Fournisseur::all();
     $categories = Categorie::all();
     return view('it.categorie.subcategorie.ajouter',[
        'fournisseurs' => $fournisseurs,
        'categories' => $categories
     ]);

    }

    public function create_subcategory()
    {
        if(request()->hasFile('photo')){
            $path = request()->file('photo')->store('', 'photo_equipement');
        }

        Sous_Categorie::create([
            'nom' => request()->nom_subcategory,
            'modele' => request()->nom_modele,
            'marque' => request()->nom_marque,
            'file_path' => $path ?? NULL,
            'id_fournisseur' => request()->id_fournisseur,
            'id_categorie' => request()->id_categorie     
        ]);

        return redirect()->route('categorie.subcategorie.show',['id_categorie' => request()->id_categorie]);
    }

    // Supprimer Sous-Catégorie
    public function supprimer_sous_categorie($id)
    {
        $sous_categorie = Categorie::findOrFail($id); 
        $sous_categorie->delete();
        return redirect()->route('categorie.subcategorie.show');
    }


    //Afficher une sous categorie
    public function show_sous_categorie($id)
    {
        $sous_categorie = Sous_Categorie::where('id',$id)->first();
        return view("it/categorie/subcategorie/show_one_subcategorie", [
            'sous_categorie' => $sous_categorie
        ]);
    }


    //Méthode Get
    public function edit_show_sous_categorie($id)
    {
        $sous_categories = Sous_Categorie::where('id', $id)->first();
        $fournisseur = Fournisseur::all();
        $categorie = Categorie::all();

        return view('it/categorie/subcategorie/modifier', [
            'sous_categories' => $sous_categories,
            
        ]);
    }


    //Méthode Post
    public function edit_sous_categorie($id, Request $request)
    {

        Sous_Categorie::where('id', $id)->update([
            'id_sous_categorie' => $request->id_sous_categorie,
            'modele' => $request->modele,
            'nom' => $request->nom,
            'marque' => $request->marque
            
        ]);

        return redirect()->route('it/categorie/subcategorie/modifier', ['id' => $id]);
    }
}
