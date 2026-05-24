<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDuenoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nombre_completo' => ['required', 'string', 'max:255'],
            'telefono'        => ['nullable', 'string', 'max:20'],
            'direccion'       => ['nullable', 'string', 'max:500'],
            'redes_sociales'  => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_completo.required' => 'El nombre completo del dueño es obligatorio.',
            'nombre_completo.max'      => 'El nombre no puede exceder los 255 caracteres.',
            'telefono.max'             => 'El teléfono no puede exceder los 20 caracteres.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre_completo' => 'nombre completo',
            'telefono'        => 'teléfono',
            'direccion'       => 'dirección',
            'redes_sociales'  => 'redes sociales',
        ];
    }
}
