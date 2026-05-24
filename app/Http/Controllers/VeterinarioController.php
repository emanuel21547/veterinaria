<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class VeterinarioController extends Controller
{
    /**
     * Vista: Diagnóstico de la consulta.
     */
    public function diagnostico(): View
    {
        return view('modules.veterinario.diagnostico');
    }

    /**
     * Vista: Tratamiento de la consulta.
     */
    public function tratamiento(): View
    {
        return view('modules.veterinario.tratamiento');
    }

    /**
     * Vista: Antecedentes – Alergias.
     */
    public function antAlergias(): View
    {
        return view('modules.veterinario.antecedentes.alergias');
    }

    /**
     * Vista: Antecedentes – Lesiones.
     */
    public function antLesiones(): View
    {
        return view('modules.veterinario.antecedentes.lesiones');
    }

    /**
     * Vista: Antecedentes – Patológicas.
     */
    public function antPatologicas(): View
    {
        return view('modules.veterinario.antecedentes.patologicas');
    }

    /**
     * Vista: Historial de Alimentación.
     */
    public function histAlimentacion(): View
    {
        return view('modules.veterinario.historial.alimentacion');
    }
}
