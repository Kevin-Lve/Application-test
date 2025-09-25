<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Gestion\Service;
use App\Models\Permission\Role;
use App\Models\Equipement\Equipement;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $guarded = [];

    // users.id_service -> service.id
    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service', 'id');
    }

    // users.id_role -> role.id
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id');
    }

    // équipements attribués à l'utilisateur (optionnel mais pratique)
    public function equipments()
    {
        return $this->hasMany(Equipement::class, 'id_attribution', 'id')
                    ->where('type_attribution', 'utilisateur');
    }
}
