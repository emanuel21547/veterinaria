<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionSistema extends Model
{
    protected $table = 'configuracion_sistema';

    protected $fillable = [
        'nombre_clinica',
        'mision',
        'vision',
        'valores',
        'historia',
        'precios_servicios',
        'direccion_fisica',
        'telefono_contacto',
        'logo_path',
    ];

    protected function casts(): array
    {
        return [
            'precios_servicios' => 'array',
        ];
    }
}
