<?php

namespace App\Models\Equipement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipementAttributValeur extends Model
{
    protected $table = 'equipement_attribut_valeurs';

    protected $fillable = [
        'id_equipement',
        'id_attribut',
        'valeur',
    ];

    public function equipement(): BelongsTo
    {
        return $this->belongsTo(Equipement::class, 'id_equipement');
    }

    public function attribut(): BelongsTo
    {
        return $this->belongsTo(SousCategorieAttribut::class, 'id_attribut');
    }
}
