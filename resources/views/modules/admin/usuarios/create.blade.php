@extends('layouts.main')

@section('titulo_pagina', 'Nuevo Usuario')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/usuarios.css') }}">
@endpush

@section('contenido')

    {{-- ── Cabecera ─────────────────────────────────────────────────── --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4 page-header">
        <div>
            <h1 class="page-title">
                <i class="fas fa-user-plus mr-2 text-primary"></i>
                Nuevo Usuario
            </h1>
            <p class="text-muted small mb-0">
                <a href="{{ route('admin.usuarios.index') }}" class="text-muted">
                    <i class="fas fa-arrow-left mr-1"></i> Volver al listado
                </a>
            </p>
        </div>
    </div>

    {{-- ── Formulario en una sola tarjeta ──────────────────────────── --}}
    <form action="{{ route('admin.usuarios.store') }}"
          method="POST"
          enctype="multipart/form-data"
          id="formCrearUsuario"
          novalidate>
        @csrf

        <div class="card card-usuarios shadow mb-4">
            <div class="card-header">
                <h6><i class="fas fa-user-plus mr-2"></i> Información del Usuario</h6>
            </div>
            <div class="card-body">

                {{-- ── Fila 1: Nombre + Email + Rol ─────────────────── --}}
                <div class="row">
                    {{-- Nombre --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="font-weight-bold small text-uppercase text-gray-600">
                                Nombre <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="Nombre completo del usuario"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email" class="font-weight-bold small text-uppercase text-gray-600">
                                Correo Electrónico <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope text-primary"></i></span>
                                </div>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       placeholder="correo@ejemplo.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Rol --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="rol" class="font-weight-bold small text-uppercase text-gray-600">
                                Rol <span class="text-danger">*</span>
                            </label>
                            <select class="form-control @error('rol') is-invalid @enderror"
                                    id="rol"
                                    name="rol"
                                    required>
                                <option value="" disabled {{ old('rol') ? '' : 'selected' }}>-- Selecciona --</option>
                                <option value="admin"       {{ old('rol') === 'admin'       ? 'selected' : '' }}>🛡️ Administrador</option>
                                <option value="veterinario" {{ old('rol') === 'veterinario' ? 'selected' : '' }}>🩺 Veterinario</option>
                            </select>
                            @error('rol')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ── Fila 2: Contraseña + Confirmar + Estado ──────── --}}
                <div class="row">
                    {{-- Contraseña --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="password" class="font-weight-bold small text-uppercase text-gray-600">
                                Contraseña <span class="text-danger">*</span>
                            </label>
                            <div class="password-wrapper">
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password"
                                       placeholder="Mínimo 8 caracteres"
                                       required>
                                <button type="button" class="toggle-password" id="togglePassword" aria-label="Ver">
                                    <i class="fas fa-eye" id="eyeIconPassword"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Confirmar contraseña --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="password_confirmation" class="font-weight-bold small text-uppercase text-gray-600">
                                Confirmar Contraseña <span class="text-danger">*</span>
                            </label>
                            <div class="password-wrapper">
                                <input type="password"
                                       class="form-control"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       placeholder="Repite la contraseña"
                                       required>
                                <button type="button" class="toggle-password" id="togglePasswordConfirm" aria-label="Ver">
                                    <i class="fas fa-eye" id="eyeIconConfirm"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600 d-block">Estado</label>
                            <div class="custom-control custom-switch mt-2">
                                <input type="checkbox" class="custom-control-input"
                                       id="activo" name="activo" value="1"
                                       {{ old('activo', '1') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="activo">
                                    Usuario activo en el sistema
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Sección veterinario (solo cuando rol = veterinario) ── --}}
                <div id="seccion-veterinario" style="display:none;">
                    <hr class="my-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="user-avatar veterinario mr-2" style="width:32px;height:32px;font-size:0.8rem;">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div>
                            <p class="font-weight-bold text-success mb-0 small text-uppercase">Datos del Veterinario</p>
                            <small class="text-muted">Todos los campos son opcionales. El nombre se tomará del campo "Nombre" si lo dejas vacío.</small>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Especialidad --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="especialidad" class="font-weight-bold small text-uppercase text-gray-600">
                                    Especialidad
                                    <span class="text-muted font-weight-normal">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('especialidad') is-invalid @enderror"
                                       id="especialidad"
                                       name="especialidad"
                                       value="{{ old('especialidad') }}"
                                       placeholder="Ej. Cirugía, Dermatología...">
                                @error('especialidad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Cédula profesional --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cedula_profesional" class="font-weight-bold small text-uppercase text-gray-600">
                                    Cédula Profesional
                                    <span class="text-muted font-weight-normal">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card text-success"></i></span>
                                    </div>
                                    <input type="text"
                                           class="form-control @error('cedula_profesional') is-invalid @enderror"
                                           id="cedula_profesional"
                                           name="cedula_profesional"
                                           value="{{ old('cedula_profesional') }}"
                                           placeholder="Número de cédula">
                                    @error('cedula_profesional')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Foto de firma --}}
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label for="foto_firma" class="font-weight-bold small text-uppercase text-gray-600">
                                    Foto de Firma
                                    <span class="text-muted font-weight-normal">(opcional)</span>
                                </label>
                                <div class="custom-file">
                                    <input type="file"
                                           class="custom-file-input @error('foto_firma') is-invalid @enderror"
                                           id="foto_firma"
                                           name="foto_firma"
                                           accept="image/png,image/jpg,image/jpeg">
                                    <label class="custom-file-label" for="foto_firma">
                                        Seleccionar imagen...
                                    </label>
                                    @error('foto_firma')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">PNG, JPG o JPEG. Máx. 2 MB.</small>
                                <img id="preview-firma" src="#" alt="Preview" class="firma-preview mt-2" style="display:none;">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer de la tarjeta: botones ─────────────────────────── --}}
            <div class="card-footer d-flex justify-content-between align-items-center">
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-1"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Guardar Usuario
                </button>
            </div>
        </div>

    </form>

@endsection

@push('scripts')
    <script src="{{ asset('js/admin/usuarios.js') }}"></script>
    <script>
        // Actualizar label del custom file input
        document.getElementById('foto_firma')?.addEventListener('change', function () {
            const fileName = this.files[0]?.name || 'Seleccionar imagen...';
            this.nextElementSibling.textContent = fileName;
        });
    </script>
@endpush
