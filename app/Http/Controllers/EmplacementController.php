<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gestion\Emplacement;

class EmplacementController extends Controller
{
    public function index()
    {
        $perPage = request('perPage', 5);        
        $emplacements = Emplacement::paginate($perPage);

        return view('it.emplacement.index', [
            'emplacements' => $emplacements
        ]);
    }
    public function create_show()
    {
        return view('it.emplacement.ajouter');
    }

    public function create()
    {
        Emplacement::create([
            'nom' => request()->nom_emplacement
        ]);

        return redirect()->route('emplacement.show.index');
    }

    public function supprimer_emplacement($id)
    {
        $emplacement = Emplacement::findOrFail($id);
        $emplacement->delete();
        return redirect()->route('emplacement.show.index');

    }

    // Visualiser Emplacement 
    public function show_emplacement($id)
    {
        $emplacement = Emplacement::where('id', $id)->first();
        return view("it/emplacement/show_one_emplacement",[
            'emplacement' => $emplacement
        ]);
    }
}
