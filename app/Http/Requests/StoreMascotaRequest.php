<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMascotaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nombre'           => ['required', 'string', 'max:100'],
            'dueno_id'         => ['nullable', 'exists:duenos,id'],
            'especie'          => ['nullable', 'string', 'max:50'],
            'raza'             => ['nullable', 'string', 'max:100'],
            'fecha_nacimiento' => ['nullable', 'date', 'before:today'],
            'tipo_sangre'      => ['nullable', 'string', 'max:20'],
            'comportamiento'   => ['nullable', 'string', 'max:255'],
            'es_adoptado'      => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'          => 'El nombre de la mascota es obligatorio.',
            'dueno_id.exists'          => 'El dueño seleccionado no existe en el sistema.',
            'fecha_nacimiento.before'  => 'La fecha de nacimiento debe ser anterior a hoy.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre'           => 'nombre de la mascota',
            'dueno_id'         => 'dueño',
            'especie'          => 'especie',
            'raza'             => 'raza',
            'fecha_nacimiento' => 'fecha de nacimiento',
            'tipo_sangre'      => 'tipo de sangre',
            'comportamiento'   => 'comportamiento',
            'es_adoptado'      => 'mascota adoptada',
        ];
    }
}
