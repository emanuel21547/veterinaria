@extends('layouts.main')

@section('titulo_pagina', 'Editar Usuario')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/usuarios.css') }}">
@endpush

@section('contenido')

    {{-- ── Cabecera ─────────────────────────────────────────────────── --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4 page-header">
        <div>
            <h1 class="page-title">
                <i class="fas fa-user-edit mr-2 text-primary"></i>
                Editar Usuario
            </h1>
            <p class="text-muted small mb-0">
                <a href="{{ route('admin.usuarios.index') }}" class="text-muted">
                    <i class="fas fa-arrow-left mr-1"></i> Volver al listado
                </a>
            </p>
        </div>
        {{-- Chip del usuario --}}
        <div class="d-flex align-items-center mt-2 mt-sm-0">
            <div class="user-avatar {{ $usuario->rol }} mr-2" style="width:44px;height:44px;font-size:1rem;">
                {{ strtoupper(substr($usuario->name, 0, 2)) }}
            </div>
            <div>
                <div class="font-weight-bold text-gray-800">{{ $usuario->name }}</div>
                <small class="text-muted">{{ $usuario->rolLabel() }}</small>
            </div>
        </div>
    </div>

    {{-- ── Formulario ───────────────────────────────────────────────── --}}
    <form action="{{ route('admin.usuarios.update', $usuario) }}"
          method="POST"
          enctype="multipart/form-data"
          id="formEditarUsuario"
          novalidate>
        @csrf
        @method('PUT')

        <div class="card card-usuarios shadow mb-4">
            <div class="card-header">
                <h6><i class="fas fa-user-edit mr-2"></i> Información del Usuario</h6>
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
                                   value="{{ old('name', $usuario->name) }}"
                                   placeholder="Nombre completo"
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
                                       value="{{ old('email', $usuario->email) }}"
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
                                    id="rol" name="rol" required>
                                <option value="admin"       {{ old('rol', $usuario->rol) === 'admin'       ? 'selected' : '' }}>🛡️ Administrador</option>
                                <option value="veterinario" {{ old('rol', $usuario->rol) === 'veterinario' ? 'selected' : '' }}>🩺 Veterinario</option>
                            </select>
                            @error('rol')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ── Fila 2: Contraseña (opcional) + Estado ───────── --}}
                <div class="row align-items-start">
                    {{-- Toggle para cambiar contraseña --}}
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600 d-block">Contraseña</label>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="btnCambiarPassword">
                                <i class="fas fa-lock mr-1"></i> Cambiar contraseña
                            </button>
                            <small class="text-muted ml-2">Déjalo sin tocar para mantener la contraseña actual.</small>

                            {{-- Campos de nueva contraseña (ocultos por defecto) --}}
                            <div id="seccion-password" style="display:none;" class="mt-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-0">
                                            <label for="password" class="small text-gray-600">Nueva contraseña</label>
                                            <div class="password-wrapper">
                                                <input type="password"
                                                       class="form-control @error('password') is-invalid @enderror"
                                                       id="password" name="password"
                                                       placeholder="Mínimo 8 caracteres">
                                                <button type="button" class="toggle-password" id="togglePassword">
                                                    <i class="fas fa-eye" id="eyeIconPassword"></i>
                                                </button>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-0">
                                            <label for="password_confirmation" class="small text-gray-600">Confirmar nueva contraseña</label>
                                            <div class="password-wrapper">
                                                <input type="password"
                                                       class="form-control"
                                                       id="password_confirmation"
                                                       name="password_confirmation"
                                                       placeholder="Repite la contraseña">
                                                <button type="button" class="toggle-password" id="togglePasswordConfirm">
                                                    <i class="fas fa-eye" id="eyeIconConfirm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                       {{ old('activo', $usuario->activo) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="activo">
                                    Usuario activo en el sistema
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Sección veterinario ──────────────────────────── --}}
                <div id="seccion-veterinario"
                     style="{{ old('rol', $usuario->rol) === 'veterinario' ? '' : 'display:none;' }}">
                    <hr class="my-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="user-avatar veterinario mr-2" style="width:32px;height:32px;font-size:0.8rem;">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div>
                            <p class="font-weight-bold text-success mb-0 small text-uppercase">Datos del Veterinario</p>
                            <small class="text-muted">Todos los campos son opcionales.</small>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Nombre completo (editable si difiere del name) --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre_completo" class="font-weight-bold small text-uppercase text-gray-600">
                                    Nombre en Expedientes
                                    <span class="text-muted font-weight-normal">(opcional)</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('nombre_completo') is-invalid @enderror"
                                       id="nombre_completo"
                                       name="nombre_completo"
                                       value="{{ old('nombre_completo', $usuario->veterinario?->nombre_completo) }}"
                                       placeholder="Nombre que aparecerá en expedientes">
                                <small class="form-text text-muted">Si lo dejas vacío, se usará "{{ $usuario->name }}".</small>
                                @error('nombre_completo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Especialidad --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="especialidad" class="font-weight-bold small text-uppercase text-gray-600">
                                    Especialidad
                                    <span class="text-muted font-weight-normal">(opcional)</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('especialidad') is-invalid @enderror"
                                       id="especialidad" name="especialidad"
                                       value="{{ old('especialidad', $usuario->veterinario?->especialidad) }}"
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
                                    <span class="text-muted font-weight-normal">(opcional)</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card text-success"></i></span>
                                    </div>
                                    <input type="text"
                                           class="form-control @error('cedula_profesional') is-invalid @enderror"
                                           id="cedula_profesional" name="cedula_profesional"
                                           value="{{ old('cedula_profesional', $usuario->veterinario?->cedula_profesional) }}"
                                           placeholder="Número de cédula">
                                    @error('cedula_profesional')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Foto de firma --}}
                        <div class="col-md-12">
                            <div class="form-group mb-0">
                                <label for="foto_firma" class="font-weight-bold small text-uppercase text-gray-600">
                                    Foto de Firma
                                    <span class="text-muted font-weight-normal">(opcional)</span>
                                </label>
                                <div class="d-flex align-items-center flex-wrap" style="gap:12px;">
                                    {{-- Preview actual --}}
                                    @if ($usuario->veterinario?->foto_firma)
                                        <div>
                                            <p class="small text-muted mb-1"><i class="fas fa-image mr-1"></i> Firma actual:</p>
                                            <img src="{{ asset('storage/' . $usuario->veterinario->foto_firma) }}"
                                                 alt="Firma actual" class="firma-preview">
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <div class="custom-file">
                                            <input type="file"
                                                   class="custom-file-input @error('foto_firma') is-invalid @enderror"
                                                   id="foto_firma" name="foto_firma"
                                                   accept="image/png,image/jpg,image/jpeg">
                                            <label class="custom-file-label" for="foto_firma">
                                                {{ $usuario->veterinario?->foto_firma ? 'Cambiar imagen...' : 'Seleccionar imagen...' }}
                                            </label>
                                            @error('foto_firma')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="form-text text-muted">PNG, JPG o JPEG. Máx. 2 MB. Deja vacío para mantener la actual.</small>
                                        <img id="preview-firma" src="#" alt="Preview" class="firma-preview mt-2" style="display:none;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer ─────────────────────────────────────────────────── --}}
            <div class="card-footer d-flex justify-content-between align-items-center">
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-1"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Actualizar Usuario
                </button>
            </div>
        </div>

    </form>

@endsection

@push('scripts')
    <script src="{{ asset('js/admin/usuarios.js') }}"></script>
    <script>
        document.getElementById('foto_firma')?.addEventListener('change', function () {
            const fileName = this.files[0]?.name || 'Seleccionar imagen...';
            this.nextElementSibling.textContent = fileName;
        });
    </script>
@endpush
