<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a hacer esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para crear un usuario.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // ── Datos del usuario ──
            'name'               => ['required', 'string', 'max:255'],
            'email'              => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'           => ['required', 'string', 'min:8', 'confirmed'],
            'rol'                => ['required', 'in:admin,veterinario'],
            'activo'             => ['boolean'],

            // ── Datos del veterinario (opcionales si rol = veterinario, con fallback a name) ──
            'nombre_completo'    => ['nullable', 'string', 'max:255'],
            'especialidad'       => ['nullable', 'string', 'max:255'],
            'cedula_profesional' => ['nullable', 'string', 'max:100'],
            'foto_firma'         => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ];
    }

    /**
     * Mensajes de error personalizados en español.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required'               => 'El nombre de usuario es obligatorio.',
            'name.max'                    => 'El nombre no puede exceder los 255 caracteres.',
            'email.required'              => 'El correo electrónico es obligatorio.',
            'email.email'                 => 'El correo electrónico no tiene un formato válido.',
            'email.unique'                => 'Este correo electrónico ya está registrado en el sistema.',
            'password.required'           => 'La contraseña es obligatoria.',
            'password.min'                => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'          => 'La confirmación de contraseña no coincide.',
            'rol.required'                => 'Debe seleccionar un rol para el usuario.',
            'rol.in'                      => 'El rol seleccionado no es válido.',
            'nombre_completo.required_if' => 'El nombre completo es obligatorio para los veterinarios.',
            'foto_firma.image'            => 'El archivo de firma debe ser una imagen.',
            'foto_firma.mimes'            => 'La firma debe estar en formato PNG, JPG o JPEG.',
            'foto_firma.max'              => 'La imagen de firma no puede superar los 2 MB.',
        ];
    }

    /**
     * Etiquetas de atributos personalizadas.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name'               => 'nombre de usuario',
            'email'              => 'correo electrónico',
            'password'           => 'contraseña',
            'rol'                => 'rol',
            'activo'             => 'estado',
            'nombre_completo'    => 'nombre completo',
            'especialidad'       => 'especialidad',
            'cedula_profesional' => 'cédula profesional',
            'foto_firma'         => 'foto de firma',
        ];
    }
}
