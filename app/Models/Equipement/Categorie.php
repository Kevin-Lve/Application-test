<?php


namespace App\Models\Equipement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorie extends Model
{
    protected $table = "categorie";
    // protected $primaryKey = "id_categorie ";
    protected $guarded = [];

    public function sousCategories(): HasMany
    {
        // Kevin: relation simple pour charger toutes les sous-catégories liées sans écrire de jointure à la main.
        return $this->hasMany(Sous_Categorie::class, 'id_categorie');
    }
}
