<?php

namespace App\Models\Equipement;

use App\Models\Com\Reseau\Vlan;
use App\Models\Gestion\Emplacement;
use App\Models\Gestion\Service;
use Illuminate\Database\Eloquent\Model;
use App\Models\ActionMateriel;


class Equipement extends Model
{
    protected $table = 'equipement';

    protected $guarded = [];

    protected $casts = [
        'date_achat' => 'datetime',
        'date_obsolescence' => 'datetime'
    ];

    

    //Jointure Service
    public function service()
    {
        return $this->hasOne(Service::class,'id','id_service');
    }

    //Jointure emplacement
    public function emplacement()
    {
        return $this->hasOne(Emplacement::class,'id','id_emplacement');
    }

    //Jointure Sous catégorie 
    public function sous_categorie()
    {
        return $this->hasOne(Sous_Categorie::class,'id','id_sous_categorie');
    }

    //Jointure Vlan
    public function vlan()
    {
        return $this->hasOne(Vlan::class,'id','id_vlan');
    }

    //Jointure action matériel
    public function action(){
        return $this->hasOne(ActionMateriel::class,'id','id_action');
    }

}


