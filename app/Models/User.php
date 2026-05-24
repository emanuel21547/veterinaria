<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Campos asignables en masa.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'activo',
    ];

    /**
     * Campos ocultos en serialización.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts de atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'activo'            => 'boolean',
        ];
    }

    // ────────────────────────────────────────────────
    // Relaciones
    // ────────────────────────────────────────────────

    /**
     * Un usuario puede tener un perfil de veterinario.
     */
    public function veterinario()
    {
        return $this->hasOne(Veterinario::class, 'usuario_id');
    }

    // ────────────────────────────────────────────────
    // Scopes
    // ────────────────────────────────────────────────

    /**
     * Filtra solo usuarios activos.
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Filtra por rol.
     */
    public function scopeDeRol($query, string $rol)
    {
        return $query->where('rol', $rol);
    }

    // ────────────────────────────────────────────────
    // Helpers
    // ────────────────────────────────────────────────

    /**
     * Devuelve true si el usuario es administrador.
     */
    public function esAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    /**
     * Devuelve true si el usuario es veterinario.
     */
    public function esVeterinario(): bool
    {
        return $this->rol === 'veterinario';
    }

    /**
     * Etiqueta legible del rol.
     */
    public function rolLabel(): string
    {
        return match ($this->rol) {
            'admin'       => 'Administrador',
            'veterinario' => 'Veterinario',
            default       => 'Sin rol',
        };
    }
}
