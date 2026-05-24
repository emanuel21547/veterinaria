<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracionSistema;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function edit()
    {
        $configuracion = ConfiguracionSistema::first() ?? new ConfiguracionSistema();
        return view('modules.admin.configuracion', compact('configuracion'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre_clinica' => ['nullable', 'string', 'max:255'],
            'telefono_contacto' => ['nullable', 'string', 'max:255'],
            'direccion_fisica' => ['nullable', 'string'],
            'mision' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'valores' => ['nullable', 'string'],
            'historia' => ['nullable', 'string'],
        ]);

        $configuracion = ConfiguracionSistema::first() ?? new ConfiguracionSistema();

        $configuracion->fill($request->only([
            'nombre_clinica', 'telefono_contacto', 'direccion_fisica',
            'mision', 'vision', 'valores', 'historia'
        ]));

        $configuracion->save();

        return back()->with('success', 'Configuración guardada correctamente.');
    }
}
