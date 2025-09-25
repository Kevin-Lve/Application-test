<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Service extends Model
{
    protected $table = "service";
    // protected $primaryKey = "id_service";
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class, 'id_service', 'id');
    }

    public function paginatedUsers($perPage = 5)
    {
    return $this->users()->paginate($perPage);
    }

}
