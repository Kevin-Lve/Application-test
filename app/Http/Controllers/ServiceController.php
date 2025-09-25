<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gestion\Service;
use App\Models\User;


class ServiceController extends Controller
{
    public function index()
    {
        $perPage = request('perPage', 5);        
        $services = Service::paginate($perPage);

        return view('it.service.index', [
            'services' => $services
        ]);
    }
    public function create_show()
    {
        return view('it.service.ajouter');
    }

    public function create()
    {
        Service::create([
            'nom' => request()->nom_service
        ]);

        return redirect()->route('service.show.index');
    }

    public function supprimer_service($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->route('service.show.index');
    }

    public function show_service($id)
{
    // Récupérer le service avec ses utilisateurs
    $service = Service::findOrFail($id);
    
    // Paginer les utilisateurs associés au service
    $users = User::where('id_service', $id)->paginate(5);

    // Retourner la vue avec les données paginées
    return view('it.service.show_service_one', [
        'service' => $service,
        'users' => $users,
    ]);
}

    
}
