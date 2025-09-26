<?php

namespace App\Models\Equipement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoriqueEquipement extends Model
{
    protected $table = 'historique_equipement';

    protected $fillable = [
        'description',
        'id_action',
        'id_utilisateur',
        'id_equipement',
    ];

    public function equipement(): BelongsTo
    {
        return $this->belongsTo(Equipement::class, 'id_equipement');
    }
}
