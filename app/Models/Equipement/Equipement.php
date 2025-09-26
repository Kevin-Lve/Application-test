<?php

namespace App\Models\Equipement;

use App\Models\ActionMateriel;
use App\Models\Com\Reseau\Vlan;
use App\Models\Gestion\Emplacement;
use App\Models\Gestion\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipement extends Model
{
    protected $table = 'equipement';

    protected $fillable = [
        'id_sous_categorie',
        'id_emplacement',
        'id_vlan',
        'id_action',
        'id_attribution',
        'id_equipement_parent',
        'type_attribution',
        'hostname',
        'numero_serie',
        'adresse_ip',
        'adresse_mac',
        'prix',
        'date_achat',
        'date_obsolescence',
        'date_livraison',
        'description',
        'numero_sku',
        'numero_tel',
        'immo',
        'imei',
        'numero_ligne',
        'code_pin',
        'code_puk',
        'forfait',
        'type_sim',
        'esim',
    ];

    protected $casts = [
        'date_achat' => 'datetime',
        'date_obsolescence' => 'datetime',
        'date_livraison' => 'datetime',
        'prix' => 'decimal:2',
        'esim' => 'boolean',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'id_attribution');
    }

    public function emplacement(): BelongsTo
    {
        return $this->belongsTo(Emplacement::class, 'id_emplacement');
    }

    public function sous_categorie(): BelongsTo
    {
        return $this->belongsTo(Sous_Categorie::class, 'id_sous_categorie');
    }

    public function vlan(): BelongsTo
    {
        return $this->belongsTo(Vlan::class, 'id_vlan');
    }

    public function action(): BelongsTo
    {
        return $this->belongsTo(ActionMateriel::class, 'id_action');
    }

    public function attributsValeurs(): HasMany
    {
        return $this->hasMany(EquipementAttributValeur::class, 'id_equipement');
    }

    public function historiques(): HasMany
    {
        return $this->hasMany(HistoriqueEquipement::class, 'id_equipement');
    }

    public function attributsDefinis(): BelongsToMany
    {
        return $this->belongsToMany(SousCategorieAttribut::class, 'equipement_attribut_valeurs', 'id_equipement', 'id_attribut');
    }
}
