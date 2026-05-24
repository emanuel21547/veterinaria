<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veterinario extends Model
{
    /**
     * Campos asignables en masa.
     *
     * @var list<string>
     */
    protected $fillable = [
        'usuario_id',
        'nombre_completo',
        'especialidad',
        'cedula_profesional',
        'foto_firma',
    ];

    // ────────────────────────────────────────────────
    // Relaciones
    // ────────────────────────────────────────────────

    /** Un veterinario pertenece a un usuario del sistema. */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /** Un veterinario puede tener muchas consultas. */
    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'veterinario_id');
    }
}
