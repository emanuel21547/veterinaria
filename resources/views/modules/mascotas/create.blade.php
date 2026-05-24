@extends('layouts.main')
@section('titulo_pagina', 'Nueva Mascota')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/usuarios.css') }}">
@endpush

@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4 page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-plus-circle mr-2 text-primary"></i> Nueva Mascota</h1>
            <p class="text-muted small mb-0">
                <a href="{{ route('mascotas.index') }}" class="text-muted"><i class="fas fa-arrow-left mr-1"></i> Volver al listado</a>
            </p>
        </div>
    </div>

    <form action="{{ route('mascotas.store') }}" method="POST" novalidate>
        @csrf
        {{-- Campo oculto para redirigir de regreso al expediente si viene desde ahí --}}
        @if(request('redirect_to'))
            <input type="hidden" name="redirect_to" value="{{ request('redirect_to') }}">
        @endif

        <div class="card card-usuarios shadow mb-4">
            <div class="card-header"><h6><i class="fas fa-paw mr-2"></i> Datos de la Mascota</h6></div>
            <div class="card-body">

                {{-- Fila 1: Nombre + Especie + Raza --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">
                                Nombre <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nombre"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   value="{{ old('nombre') }}" placeholder="Nombre de la mascota" required>
                            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Especie</label>
                            <select name="especie" class="form-control @error('especie') is-invalid @enderror">
                                <option value="">-- Seleccionar --</option>
                                @foreach(['Perro','Gato','Ave','Conejo','Reptil','Hamster','Otro'] as $esp)
                                    <option value="{{ $esp }}" {{ old('especie') === $esp ? 'selected' : '' }}>
                                        {{ $esp }}
                                    </option>
                                @endforeach
                            </select>
                            @error('especie')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Raza</label>
                            <input type="text" name="raza"
                                   class="form-control @error('raza') is-invalid @enderror"
                                   value="{{ old('raza') }}" placeholder="Ej. Labrador, Siamés...">
                            @error('raza')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Fila 2: Fecha nacimiento + Tipo sangre + Comportamiento --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento"
                                   class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                   value="{{ old('fecha_nacimiento') }}" max="{{ date('Y-m-d') }}">
                            @error('fecha_nacimiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Tipo de Sangre</label>
                            <input type="text" name="tipo_sangre"
                                   class="form-control @error('tipo_sangre') is-invalid @enderror"
                                   value="{{ old('tipo_sangre') }}" placeholder="Ej. DEA 1+, A, B...">
                            @error('tipo_sangre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Comportamiento</label>
                            <input type="text" name="comportamiento"
                                   class="form-control @error('comportamiento') is-invalid @enderror"
                                   value="{{ old('comportamiento') }}" placeholder="Ej. Tranquilo, Agresivo...">
                            @error('comportamiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Fila 3: Dueño + Adoptado --}}
                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="form-group mb-0">
                            <label class="font-weight-bold small text-uppercase text-gray-600">
                                Dueño <span class="text-muted font-weight-normal">(opcional)</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user text-primary"></i></span>
                                </div>
                                <select name="dueno_id" class="form-control @error('dueno_id') is-invalid @enderror">
                                    <option value="">-- Sin dueño registrado --</option>
                                    @foreach($duenos as $dueno)
                                        <option value="{{ $dueno->id }}"
                                            {{ (old('dueno_id', $duenoPreseleccionado) == $dueno->id) ? 'selected' : '' }}>
                                            {{ $dueno->nombre_completo }}
                                            @if($dueno->telefono) ({{ $dueno->telefono }}) @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('dueno_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <small class="form-text text-muted">
                                ¿No encuentras al dueño?
                                <a href="{{ route('duenos.create') }}" target="_blank">Registrar nuevo dueño</a>
                            </small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <label class="font-weight-bold small text-uppercase text-gray-600 d-block">Estado</label>
                            <div class="custom-control custom-switch mt-2">
                                <input type="checkbox" class="custom-control-input"
                                       id="es_adoptado" name="es_adoptado" value="1"
                                       {{ old('es_adoptado') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="es_adoptado">
                                    Mascota adoptada
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('mascotas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-1"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Guardar Mascota
                </button>
            </div>
        </div>
    </form>
@endsection
