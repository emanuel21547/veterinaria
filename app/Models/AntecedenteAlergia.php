<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntecedenteAlergia extends Model
{
    protected $fillable = [
        'mascota_id',
        'sustancia_alergena',
        'reaccion',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }
}
