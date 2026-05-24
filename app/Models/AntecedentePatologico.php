<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntecedentePatologico extends Model
{
    protected $fillable = [
        'mascota_id',
        'enfermedad',
        'es_cronica',
    ];

    protected function casts(): array
    {
        return [
            'es_cronica' => 'boolean',
        ];
    }

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }
}
