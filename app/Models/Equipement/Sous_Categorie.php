<?php

namespace App\Models\Equipement;

use App\Models\Fournisseur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sous_Categorie extends Model
{
    protected $table = 'sous_categorie';

    protected $guarded = [];

    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class, 'id_fournisseur');
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'id_categorie');
    }

    public function attributs(): HasMany
    {
        return $this->hasMany(SousCategorieAttribut::class, 'id_sous_categorie');
    }
}
