<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionMateriel extends Model
{
    protected $table = 'action_materiel';
    
    protected $fillable = ['nom'];

    public function equipements()
    {
        return $this->hasMany(\App\Models\Equipement\Equipement::class, 'id_action');
    }
}