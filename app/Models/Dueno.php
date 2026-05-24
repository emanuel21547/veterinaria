<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dueno extends Model
{
    protected $table = 'duenos';

    protected $fillable = [
        'nombre_completo',
        'telefono',
        'direccion',
        'redes_sociales',
    ];

    // ── Relaciones ──────────────────────────────────────────────

    /** Un dueño puede tener muchas mascotas. */
    public function mascotas()
    {
        return $this->hasMany(Mascota::class, 'dueno_id');
    }

    // ── Helpers ─────────────────────────────────────────────────

    /** Número de mascotas del dueño. */
    public function totalMascotas(): int
    {
        return $this->mascotas()->count();
    }
}
