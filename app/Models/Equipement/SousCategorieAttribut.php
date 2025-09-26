<?php

namespace App\Models\Equipement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SousCategorieAttribut extends Model
{
    protected $table = 'sous_categorie_attributs';

    protected $fillable = [
        'id_sous_categorie',
        'nom_attribut',
        'type',
        'options',
        'obligatoire',
    ];

    protected $casts = [
        'options' => 'array',
        'obligatoire' => 'boolean',
    ];

    public function sousCategorie(): BelongsTo
    {
        return $this->belongsTo(Sous_Categorie::class, 'id_sous_categorie');
    }

    public function valeurs(): HasMany
    {
        return $this->hasMany(EquipementAttributValeur::class, 'id_attribut');
    }
}
