<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\User;
use App\Models\Veterinario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    /**
     * Muestra el listado de todos los usuarios.
     */
    public function index(): View
    {
        $usuarios = User::with('veterinario')
                        ->orderByDesc('created_at')
                        ->paginate(10);

        return view('modules.admin.usuarios.index', compact('usuarios'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create(): View
    {
        return view('modules.admin.usuarios.create');
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     * Usa transacción para garantizar integridad de datos.
     */
    public function store(StoreUsuarioRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            // ── Crear el usuario ──
            $usuario = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $request->password, // el modelo aplica Hash automáticamente
                'rol'      => $request->rol,
                'activo'   => $request->boolean('activo', true),
            ]);

            // ── Si es veterinario, crear su perfil ──
            if ($request->rol === 'veterinario') {
                $datosFirma = [];

                if ($request->hasFile('foto_firma')) {
                    $datosFirma['foto_firma'] = $request->file('foto_firma')
                        ->store('firmas', 'public');
                }

                $usuario->veterinario()->create([
                    // Si no se proporcionó nombre_completo, usamos el nombre de usuario
                    'nombre_completo'    => $request->filled('nombre_completo')
                                               ? $request->nombre_completo
                                               : $request->name,
                    'especialidad'       => $request->especialidad,
                    'cedula_profesional' => $request->cedula_profesional,
                    'foto_firma'         => $datosFirma['foto_firma'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Muestra el formulario de edición de un usuario.
     */
    public function edit(User $usuario): View
    {
        $usuario->load('veterinario');
        return view('modules.admin.usuarios.edit', compact('usuario'));
    }

    /**
     * Actualiza los datos de un usuario existente.
     * Usa transacción para garantizar integridad de datos.
     */
    public function update(UpdateUsuarioRequest $request, User $usuario): RedirectResponse
    {
        DB::transaction(function () use ($request, $usuario) {
            // ── Actualizar datos base del usuario ──
            $datosUsuario = [
                'name'   => $request->name,
                'email'  => $request->email,
                'rol'    => $request->rol,
                'activo' => $request->boolean('activo', true),
            ];

            // Solo actualiza contraseña si se proporcionó una nueva
            if ($request->filled('password')) {
                $datosUsuario['password'] = $request->password;
            }

            $usuario->update($datosUsuario);

            // ── Gestionar perfil de veterinario ──
            if ($request->rol === 'veterinario') {
                $datosFirma = [];

                if ($request->hasFile('foto_firma')) {
                    // Eliminar firma anterior si existe
                    if ($usuario->veterinario?->foto_firma) {
                        Storage::disk('public')->delete($usuario->veterinario->foto_firma);
                    }

                    $datosFirma['foto_firma'] = $request->file('foto_firma')
                        ->store('firmas', 'public');
                }

                $usuario->veterinario()->updateOrCreate(
                    ['usuario_id' => $usuario->id],
                    array_merge([
                        'nombre_completo'    => $request->filled('nombre_completo')
                                                   ? $request->nombre_completo
                                                   : $request->name,
                        'especialidad'       => $request->especialidad,
                        'cedula_profesional' => $request->cedula_profesional,
                    ], $datosFirma)
                );
            } else {
                // Si cambió a admin, eliminar perfil de veterinario si existía
                if ($usuario->veterinario) {
                    if ($usuario->veterinario->foto_firma) {
                        Storage::disk('public')->delete($usuario->veterinario->foto_firma);
                    }
                    $usuario->veterinario()->delete();
                }
            }
        });

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina un usuario del sistema.
     * No permite eliminar la propia cuenta del usuario autenticado.
     */
    public function destroy(User $usuario): RedirectResponse
    {
        if ($usuario->id === auth()->id()) {
            return redirect()
                ->route('admin.usuarios.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        DB::transaction(function () use ($usuario) {
            // Eliminar firma si existe
            if ($usuario->veterinario?->foto_firma) {
                Storage::disk('public')->delete($usuario->veterinario->foto_firma);
            }
            $usuario->delete(); // cascade eliminará el veterinario por FK
        });

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
