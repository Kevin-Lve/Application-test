<?php

namespace App\Models\Equipement;

use App\Models\Fournisseur;
use App\Models\Equipement\Categorie;
use Illuminate\Database\Eloquent\Model;

class Sous_Categorie extends Model
{
    protected $table = 'sous_categorie';

    protected $guarded = [];

    public function fournisseur()
    {
        return $this->hasOne(Fournisseur::class, 'id', 'id_fournisseur');
    }

    public function categorie(){

        return $this->hasOne(Categorie::class,'id', 'id_categorie');
    }
}
