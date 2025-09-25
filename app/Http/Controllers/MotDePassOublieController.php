<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Gestion\Service;
use Illuminate\Support\Facades\Auth;

class MotDePassOublieController extends Controller 
{

    public function show_forgot()
    {
        return view('auth/forgot_password');
    }


}