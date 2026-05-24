<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    protected $fillable = [
        'dueno_id',
        'nombre',
        'especie',
        'raza',
        'fecha_nacimiento',
        'tipo_sangre',
        'comportamiento',
        'es_adoptado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
            'es_adoptado'      => 'boolean',
        ];
    }

    // ── Relaciones ──────────────────────────────────────────────

    /** La mascota pertenece a un dueño (nullable). */
    public function dueno()
    {
        return $this->belongsTo(Dueno::class, 'dueno_id');
    }

    /** Una mascota puede tener muchas consultas. */
    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'mascota_id');
    }

    /** Última consulta registrada. */
    public function ultimaConsulta()
    {
        return $this->hasOne(Consulta::class, 'mascota_id')->latestOfMany('fecha_consulta');
    }

    // ── Helpers ─────────────────────────────────────────────────

    /** Folio formateado (ej: 001). */
    public function folioFormateado(): string
    {
        return str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }

    /** Edad en años calculada desde fecha_nacimiento. */
    public function edadAnios(): ?string
    {
        if (!$this->fecha_nacimiento) return null;
        $anios = $this->fecha_nacimiento->diffInYears(now());
        $meses = $this->fecha_nacimiento->diffInMonths(now()) % 12;
        return $anios > 0 ? "{$anios} año(s)" : "{$meses} mes(es)";
    }

    /** Emoji de especie. */
    public function emojiEspecie(): string
    {
        return match (strtolower($this->especie ?? '')) {
            'perro'   => '🐕',
            'gato'    => '🐈',
            'ave'     => '🦜',
            'conejo'  => '🐇',
            'reptil'  => '🦎',
            'hamster' => '🐹',
            default   => '🐾',
        };
    }
}
