<?php

namespace App\Http\Controllers;

use App\Models\Gestion\Service;
use App\Models\Permission\Role;
use App\Models\User;
use App\Models\Equipement\Equipement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search  = $request->input('search');     // Mot-clé
        $perPage = (int) $request->input('perPage', 5); // Pagination configurable

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nom', 'like', "%{$search}%")
                      ->orWhere('prenom', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->paginate($perPage)
            ->withQueryString(); // conserve les paramètres dans la pagination

        return view('it.user.index', [
            'users'  => $users,
            'search' => $search,
        ]);
    }

    public function create_show()
    {
        $services = Service::all();
        $roles    = Role::all();

        return view('it.user.ajouter', [
            'services' => $services,
            'roles'    => $roles,
        ]);
    }

    public function create(Request $request)
    {
        // (Optionnel) à terme, remplace par une FormRequest pour valider proprement
        User::create([
            'nom'        => $request->input('nom_user'),
            'prenom'     => $request->input('prenom_user'),
            'email'      => $request->input('email_user'),
            'id_service' => $request->input('id_service'),
            'id_role'    => $request->input('id_role'),
            'password'   => Hash::make(Str::password(8)),
        ]);

        return redirect()->route('user.show.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function supprimer_utilisateur($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.show.index')
            ->with('success', 'Utilisateur supprimé.');
    }

    public function show_utilisateur($id)
    {
        // Utilisateur + relations
        $user = User::with(['service', 'role'])->findOrFail($id);

        // Équipements attribués à cet utilisateur
        $equipements = Equipement::with([
                'sous_categorie',
                'emplacement',
                'vlan',
                'sous_categorie.fournisseur',
                'action', // <= la virgule manquante était ici
            ])
            ->where('type_attribution', 'utilisateur')
            ->where('id_attribution', $id)
            ->orderByDesc('id')
            ->paginate(15)
            ->onEachSide(1);

        // KPIs 
        $nb_equipements = $equipements->total();
        $valeur_totale  = Equipement::where('type_attribution', 'utilisateur')
                            ->where('id_attribution', $id)
                            ->sum('prix');

        $dernier_attribue = optional(
            Equipement::where('type_attribution', 'utilisateur')
                ->where('id_attribution', $id)
                ->latest('created_at')
                ->first()
        )->created_at;

        return view('it.user.show_one_utilisateur', compact(
            'user',
            'equipements',
            'nb_equipements',
            'valeur_totale',
            'dernier_attribue'
        ));
    }
}
