<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consommable extends Model
{
    use HasFactory;

    protected $table = 'consommables';

    protected $fillable = [
        'nom',
        'reference',
        'code_barre',
        'numero_serie',
        'immo',
        'adresse_mac',
        'quantite_stock',
        'quantite_minimale',
    ];

    protected $casts = [
        'quantite_stock' => 'integer',
        'quantite_minimale' => 'integer',
    ];
}
