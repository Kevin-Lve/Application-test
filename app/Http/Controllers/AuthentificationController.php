<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Gestion\Service;
use Illuminate\Support\Facades\Auth;

class AuthentificationController extends Controller
{
    public function show_login()
    {
        return view("auth/login");
    }

//Valider les données de la requête
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]); 
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard.show');
        }
 
        return back()->withErrors([
            'general' => ' E-mail ou mot de passe incorrect. ',
        ]);
    }


    public function liste_service()
    {
        $service = Service::whereLike("nom", "%Service%")->update([
            "nom" => "un seul service"
        ]);

        dd($service);

        // return view("service",[
        //     "services" => $services
        // ]);
        //dd($services);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

 

   
}
