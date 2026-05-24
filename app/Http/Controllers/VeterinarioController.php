<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Mascota;
use App\Models\Veterinario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VeterinarioController extends Controller
{
    // ════════════════════════════════════════════════════════════════
    // EXPEDIENTE — Pantalla principal del veterinario
    // ════════════════════════════════════════════════════════════════

    /**
     * Muestra el buscador de expedientes.
     * Esta es la pantalla de inicio del veterinario.
     */
    public function expediente(): View
    {
        return view('modules.veterinario.expediente.index');
    }

    /**
     * AJAX: busca mascotas por nombre propio o por nombre del dueño.
     * Devuelve JSON para el buscador en tiempo real.
     */
    public function buscar(Request $request): JsonResponse
    {
        $q = trim($request->get('q', ''));

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $mascotas = Mascota::with('dueno')
            ->where(function ($query) use ($q) {
                $query->where('mascotas.nombre', 'like', "%{$q}%")
                      ->orWhereHas('dueno', function ($d) use ($q) {
                          $d->where('nombre_completo', 'like', "%{$q}%");
                      });
            })
            ->orderBy('nombre')
            ->limit(10)
            ->get();

        return response()->json(
            $mascotas->map(function (Mascota $m) {
                return [
                    'id'            => $m->id,
                    'nombre'        => $m->nombre,
                    'especie'       => $m->especie,
                    'emoji'         => $m->emojiEspecie(),
                    'folio'         => $m->folioFormateado(),
                    'dueno'         => $m->dueno?->nombre_completo,
                    'urlConsultas'  => route('veterinario.mascota.consultas', $m),
                    'urlNuevaMascota' => route('mascotas.create'),
                ];
            })
        );
    }

    /**
     * Muestra el historial de consultas de una mascota.
     */
    public function consultas(Mascota $mascota): View
    {
        $consultas = $mascota->consultas()
                             ->with('veterinario.usuario')
                             ->orderByDesc('fecha_consulta')
                             ->get();

        return view('modules.veterinario.expediente.consultas', compact('mascota', 'consultas'));
    }

    /**
     * Muestra el formulario de nueva consulta.
     */
    public function crearConsulta(Mascota $mascota): View
    {
        return view('modules.veterinario.expediente.nueva-consulta', compact('mascota'));
    }

    /**
     * Guarda una nueva consulta.
     */
    public function guardarConsulta(Request $request): RedirectResponse
    {
        $request->validate([
            'mascota_id'     => ['required', 'exists:mascotas,id'],
            'fecha_consulta' => ['required', 'date'],
            'peso'           => ['nullable', 'numeric', 'min:0', 'max:999'],
            'talla'          => ['nullable', 'numeric', 'min:0', 'max:999'],
            'diagnostico'    => ['nullable', 'string'],
            'tratamiento'    => ['nullable', 'string'],
            'antecedentes_alergias'    => ['nullable', 'string'],
            'antecedentes_lesiones'    => ['nullable', 'string'],
            'antecedentes_patologicas' => ['nullable', 'string'],
            'historial_alimentacion'   => ['nullable', 'string'],
        ]);

        // Obtener el perfil de veterinario del usuario actual
        $vet = Veterinario::where('usuario_id', Auth::id())->first();

        if (!$vet) {
            return back()->with('error', 'Tu usuario no tiene perfil de veterinario configurado. Contacta al administrador.');
        }

        $mascota = Mascota::findOrFail($request->mascota_id);

        Consulta::create([
            'mascota_id'               => $request->mascota_id,
            'veterinario_id'           => $vet->id,
            'fecha_consulta'           => $request->fecha_consulta,
            'peso'                     => $request->peso,
            'talla'                    => $request->talla,
            'diagnostico'              => $request->diagnostico,
            'tratamiento'              => $request->tratamiento,
            'antecedentes_alergias'    => $request->antecedentes_alergias,
            'antecedentes_lesiones'    => $request->antecedentes_lesiones,
            'antecedentes_patologicas' => $request->antecedentes_patologicas,
            'historial_alimentacion'   => $request->historial_alimentacion,
        ]);

        return redirect()
            ->route('veterinario.mascota.consultas', $mascota)
            ->with('success', 'Consulta registrada correctamente.');
    }

    /**
     * Muestra el formulario de edición de una consulta.
     */
    public function editarConsulta(Consulta $consulta): View
    {
        $consulta->load('mascota');
        return view('modules.veterinario.expediente.editar-consulta', compact('consulta'));
    }

    /**
     * Actualiza una consulta existente.
     */
    public function actualizarConsulta(Request $request, Consulta $consulta): RedirectResponse
    {
        $request->validate([
            'fecha_consulta' => ['required', 'date'],
            'peso'           => ['nullable', 'numeric', 'min:0'],
            'talla'          => ['nullable', 'numeric', 'min:0'],
            'diagnostico'    => ['nullable', 'string'],
            'tratamiento'    => ['nullable', 'string'],
            'antecedentes_alergias'    => ['nullable', 'string'],
            'antecedentes_lesiones'    => ['nullable', 'string'],
            'antecedentes_patologicas' => ['nullable', 'string'],
            'historial_alimentacion'   => ['nullable', 'string'],
        ]);

        $consulta->update($request->only([
            'fecha_consulta', 'peso', 'talla', 'diagnostico', 'tratamiento',
            'antecedentes_alergias', 'antecedentes_lesiones',
            'antecedentes_patologicas', 'historial_alimentacion',
        ]));

        return redirect()
            ->route('veterinario.mascota.consultas', $consulta->mascota)
            ->with('success', 'Consulta actualizada correctamente.');
    }

    // ════════════════════════════════════════════════════════════════
    // SECCIONES DEL MENÚ LATERAL (vistas placeholder)
    // ════════════════════════════════════════════════════════════════

    public function diagnostico(): View
    {
        return view('modules.veterinario.diagnostico');
    }

    public function tratamiento(): View
    {
        return view('modules.veterinario.tratamiento');
    }

    public function antAlergias(): View
    {
        return view('modules.veterinario.antecedentes.alergias');
    }

    public function antLesiones(): View
    {
        return view('modules.veterinario.antecedentes.lesiones');
    }

    public function antPatologicas(): View
    {
        return view('modules.veterinario.antecedentes.patologicas');
    }

    public function histAlimentacion(): View
    {
        return view('modules.veterinario.historial.alimentacion');
    }
}
