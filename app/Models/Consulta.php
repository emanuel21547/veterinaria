<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $fillable = [
        'mascota_id',
        'veterinario_id',
        'fecha_consulta',
        'peso',
        'talla',
        'diagnostico',
        'tratamiento',
    ];

    protected function casts(): array
    {
        return [
            'fecha_consulta' => 'datetime',
            'peso'           => 'decimal:2',
            'talla'          => 'decimal:2',
        ];
    }

    // ── Relaciones ──────────────────────────────────────────────

    /** La consulta pertenece a una mascota. */
    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }

    /** La consulta fue atendida por un veterinario. */
    public function veterinario()
    {
        return $this->belongsTo(Veterinario::class, 'veterinario_id');
    }
}
