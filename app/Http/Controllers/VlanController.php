<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Com\Reseau\Vlan;

class VlanController extends Controller
{
    public function index()
    {
        $perPage = request('perPage', 5);        
        $vlans = Vlan::paginate($perPage);

        return view('it.vlan.index', [
            'vlans' => $vlans
        ]);
    }
    public function create_show()
    {
        return view('it.vlan.ajouter');
    }

    public function create()
    {
        Vlan::create([
            'nom' => request()->nom_vlan,
            'num_vlan' => request()->num_vlan,
            'passerelle_defaut' => request()->passerelle_defaut,
            'ip_debut' => request()->nom_ip_debut,
            'ip_fin' => request()->nom_ip_fin,
            'masque' => request()->nom_masque,
            'is_dhcp' => request()->has('nom_is_dhcp') ? 1 : 0,
        ]);

        return redirect()->route('vlan.show.index');
    }

    public function supprimer_vlan($id)
    {
        $vlan = Vlan::findOrFail($id);
        $vlan->delete();
        return redirect()->route('vlan.show.index');
    }

    public function show_vlan($id)
    {
        $vlan = Vlan::where('id',$id)->first();
        return view('it/vlan/show_one_vlan', [
            'vlan' => $vlan
        ]);

    }
}
