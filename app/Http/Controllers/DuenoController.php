<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDuenoRequest;
use App\Http\Requests\UpdateDuenoRequest;
use App\Models\Dueno;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DuenoController extends Controller
{
    public function index(): View
    {
        $duenos = Dueno::withCount('mascotas')
                       ->orderByDesc('created_at')
                       ->paginate(10);

        return view('modules.duenos.index', compact('duenos'));
    }

    public function create(): View
    {
        return view('modules.duenos.create');
    }

    public function store(StoreDuenoRequest $request): RedirectResponse
    {
        Dueno::create($request->validated());

        return redirect()
            ->route('duenos.index')
            ->with('success', 'Dueño registrado correctamente.');
    }

    public function edit(Dueno $dueno): View
    {
        return view('modules.duenos.edit', compact('dueno'));
    }

    public function update(UpdateDuenoRequest $request, Dueno $dueno): RedirectResponse
    {
        $dueno->update($request->validated());

        return redirect()
            ->route('duenos.index')
            ->with('success', 'Dueño actualizado correctamente.');
    }

    public function destroy(Dueno $dueno): RedirectResponse
    {
        if ($dueno->mascotas()->count() > 0) {
            return redirect()
                ->route('duenos.index')
                ->with('error', 'No se puede eliminar: el dueño tiene mascotas registradas.');
        }

        $dueno->delete();

        return redirect()
            ->route('duenos.index')
            ->with('success', 'Dueño eliminado correctamente.');
    }
}
