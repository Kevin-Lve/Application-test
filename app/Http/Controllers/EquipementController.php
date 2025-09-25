<?php

namespace App\Http\Controllers;

use App\Models\Com\Reseau\Vlan;
use App\Models\Equipement\Equipement;
use App\Models\Gestion\Emplacement;
use App\Models\Gestion\Service;
use Illuminate\Http\Request;
use App\Models\Equipement\Sous_Categorie;
use App\Models\User;
use App\Models\ActionMateriel;

class EquipementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // Récupération du mot-clé de recherche
        $perPage = $request->input('perPage', 20); // Pagination configurable
    
        $equipements = Equipement::query()
            ->with(['emplacement', 'sous_categorie', 'vlan','action'])
            ->when($search, function ($query, $search) {
                $query->where('numero_serie', 'like', "%{$search}%") // Recherche par numéro de série
                      ->orWhere('adresse_ip', 'like', "%{$search}%") // Recherche par adresse IP
                      ->orWhere('adresse_mac', 'like', "%{$search}%") // Recherche par adresse MAC
                      ->orWhereHas('sous_categorie', function ($q) use ($search) {
                          $q->where('nom', 'like', "%{$search}%"); // Recherche par sous-catégorie
                      })
                      ->orWhereHas('emplacement', function ($q) use ($search) {
                          $q->where('nom', 'like', "%{$search}%"); // Recherche par emplacement
                      });
            })
            ->paginate($perPage);
    
        return view('it.equipement.index', [
            'equipements' => $equipements,
            'search' => $search, // Pour conserver la valeur saisie dans le champ
        ]);
    }
    

    public function create_show()
    {
        $emplacements = Emplacement::all();
        $sous_categories = Sous_Categorie::all();
        $users = User::all();
        $vlans = Vlan::all();
        $services = Service::all();
        $actions = ActionMateriel::all();

        return view('it.equipement.ajoute', [
            'emplacements' => $emplacements,
            'sous_categories' => $sous_categories,
            'vlans' => $vlans,
            'users' => $users,
            'services' => $services,
            
            'actions' => $actions
        ]);
    }

    public function create_equipement(Request $request)
    {

        // Déterminer l'attribution (Service ou Utilisateur)
        $id_attribution = null;
        if ($request->type_attribution === 'service') {
            $id_attribution = $request->id_service;
        } elseif ($request->type_attribution === 'utilisateur') {
            $id_attribution = $request->id_utilisateur;
        }

        // Vérifier si l'équipement est un équipement réseau
        $isNetworkEquipment = $request->input('equipement_reseau') === 'oui';

        $equipement = Equipement::create([
            'id_sous_categorie' => $request->id_sous_categorie,
            'hostname' => $request->hostname,
            'numero_serie' => $request->sn,
            'prix' => $request->prix,
            'date_achat' => $request->date_achat,
            'date_obsolescence' => $request->date_obsolescence,
            'date_livraison' => $request->date_livraison,
            'description' => $request->description,
            'type_attribution' => $request->type_attribution,
            'id_attribution' => $id_attribution,
            'id_emplacement' => $request->id_emplacement,
            'id_vlan' => $isNetworkEquipment ? $request->id_vlan : null,
            'adresse_ip' => $isNetworkEquipment ? $request->adresse_ip : null,
            'adresse_mac' => $isNetworkEquipment ? $request->adresse_mac : null,
            'numero_sku' => $request->numero_sku,
            'numero_tel' => $request->numero_tel,
            'immo' => $request->immo,
            'imei' => $request->imei,
            'numero_ligne' => $request->numero_ligne,
            'code_pin' => $request->code_pin,
            'code_puk' => $request->code_puk,
            'forfait' => $request->forfait,
            'type_sim' => $request->type_sim,
            'esim' => $request->esim ? 1 : 0,
            'id_equipement_parent' => $request->id_equipement_parent,
            'id_action' => $request->id_action,
        ]);

        return redirect()->route('it.equipement.show', ['id' => $equipement->id]);
    }


    //Redirection vers id equipement -> adresse mac (view)
    public function show_equipement($id )
    {
        $equipement = Equipement::where('id', $id)->with('sous_categorie.fournisseur','sous_categorie.categorie','action')->first();
        // dd($equipement);
        //dd($equipement->toRawSql()); ="select * from `equipement` where `id` = '1's
        return view("it/equipement/afficher",[
            'equipement' => $equipement
        ]);
    }

    //Supprimer équipemement 
    public function supprimer_equipement($id)
    {
        $equipement=Equipement::findOrFail($id); // Récuperer equipement à supprimer 
        $equipement->delete(); //Supprimer equipement
        return redirect()->route('equipement.show.index');//->with('success', 'Equipement suprrimé avec succès.');
    }

    public function edit_show($id)
    {
        $emplacements = Emplacement::all();
        $sous_categories = Sous_Categorie::all();
        $users = User::all();
        $vlans = Vlan::all();
        $services = Service::all();
        $equipement = Equipement::where('id', $id)->first();

        return view('it.equipement.modifier', [
            'emplacements' => $emplacements,
            'sous_categories' => $sous_categories,
            'vlans' => $vlans,
            'users' => $users,
            'services' => $services,
            'equipement' => $equipement
        ]);
    }

    public function edit($id, Request $request)
    {
        $id_attribution = null;
        if ($request->type_attribution === 'service') {
            $id_attribution = $request->id_service;
        } elseif ($request->type_attribution === 'utilisateur') {
            $id_attribution = $request->id_utilisateur;
        }

        // Vérifier si l'équipement est un équipement réseau
        $isNetworkEquipment = $request->input('equipement_reseau') === 'oui';

        Equipement::where('id', $id)->update([
            'id_sous_categorie' => $request->id_sous_categorie,
            'numero_serie' => $request->sn,
            'prix' => $request->prix,
            'date_achat' => $request->date_achat,
            'date_obsolescence' => $request->date_obsolescence,
            'description' => $request->description,
            'type_attribution' => $request->type_attribution,
            'id_attribution' => $id_attribution,
            'id_emplacement' => $request->id_emplacement,
            'id_vlan' => $isNetworkEquipment ? $request->id_vlan : null, // Réinitialisation si non réseau
            'adresse_ip' => $isNetworkEquipment ? $request->adresse_ip : null, // Réinitialisation si non réseau
            'adresse_mac' => $isNetworkEquipment ? $request->adresse_mac : null, // Réinitialisation si non réseau
        ]);

        return redirect()->route('it.equipement.show', ['id' => $id]);
    }

    
}

