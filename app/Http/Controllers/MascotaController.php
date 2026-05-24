<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMascotaRequest;
use App\Http\Requests\UpdateMascotaRequest;
use App\Models\Dueno;
use App\Models\Mascota;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MascotaController extends Controller
{
    public function index(): View
    {
        $mascotas = Mascota::with('dueno')
                           ->withCount('consultas')
                           ->orderByDesc('created_at')
                           ->paginate(10);

        return view('modules.mascotas.index', compact('mascotas'));
    }

    public function create(): View
    {
        $duenos = Dueno::orderBy('nombre_completo')->get();

        // Si viene desde el expediente con un dueño ya seleccionado
        $duenoPreseleccionado = request('dueno_id');

        return view('modules.mascotas.create', compact('duenos', 'duenoPreseleccionado'));
    }

    public function store(StoreMascotaRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['es_adoptado'] = $request->boolean('es_adoptado');

        Mascota::create($data);

        // Si viene del expediente, regresar al expediente
        if ($request->filled('redirect_to')) {
            return redirect($request->redirect_to)
                ->with('success', 'Mascota registrada correctamente.');
        }

        return redirect()
            ->route('mascotas.index')
            ->with('success', 'Mascota registrada correctamente.');
    }

    public function edit(Mascota $mascota): View
    {
        $duenos = Dueno::orderBy('nombre_completo')->get();
        return view('modules.mascotas.edit', compact('mascota', 'duenos'));
    }

    public function update(UpdateMascotaRequest $request, Mascota $mascota): RedirectResponse
    {
        $data = $request->validated();
        $data['es_adoptado'] = $request->boolean('es_adoptado');

        $mascota->update($data);

        return redirect()
            ->route('mascotas.index')
            ->with('success', 'Mascota actualizada correctamente.');
    }

    public function destroy(Mascota $mascota): RedirectResponse
    {
        if ($mascota->consultas()->count() > 0) {
            return redirect()
                ->route('mascotas.index')
                ->with('error', 'No se puede eliminar: la mascota tiene consultas registradas.');
        }

        $mascota->delete();

        return redirect()
            ->route('mascotas.index')
            ->with('success', 'Mascota eliminada correctamente.');
    }
}
