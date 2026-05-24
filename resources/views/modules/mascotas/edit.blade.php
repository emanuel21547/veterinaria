@extends('layouts.main')
@section('titulo_pagina', 'Editar Mascota')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/usuarios.css') }}">
@endpush

@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4 page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-edit mr-2 text-primary"></i> Editar Mascota</h1>
            <p class="text-muted small mb-0">
                <a href="{{ route('mascotas.index') }}" class="text-muted"><i class="fas fa-arrow-left mr-1"></i> Volver al listado</a>
            </p>
        </div>
        <div class="d-flex align-items-center">
            <div class="user-avatar veterinario mr-2" style="width:44px;height:44px;font-size:1.2rem;">
                {{ $mascota->emojiEspecie() }}
            </div>
            <div>
                <div class="font-weight-bold">{{ $mascota->nombre }}</div>
                <small class="text-muted">Folio #{{ $mascota->folioFormateado() }}</small>
            </div>
        </div>
    </div>

    <form action="{{ route('mascotas.update', $mascota) }}" method="POST" novalidate>
        @csrf @method('PUT')
        <div class="card card-usuarios shadow mb-4">
            <div class="card-header"><h6><i class="fas fa-edit mr-2"></i> Datos de la Mascota</h6></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">
                                Nombre <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nombre"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   value="{{ old('nombre', $mascota->nombre) }}" required>
                            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Especie</label>
                            <select name="especie" class="form-control">
                                <option value="">-- Seleccionar --</option>
                                @foreach(['Perro','Gato','Ave','Conejo','Reptil','Hamster','Otro'] as $esp)
                                    <option value="{{ $esp }}" {{ old('especie', $mascota->especie) === $esp ? 'selected' : '' }}>
                                        {{ $esp }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Raza</label>
                            <input type="text" name="raza" class="form-control"
                                   value="{{ old('raza', $mascota->raza) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" class="form-control"
                                   value="{{ old('fecha_nacimiento', $mascota->fecha_nacimiento?->format('Y-m-d')) }}"
                                   max="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Tipo de Sangre</label>
                            <input type="text" name="tipo_sangre" class="form-control"
                                   value="{{ old('tipo_sangre', $mascota->tipo_sangre) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Comportamiento</label>
                            <input type="text" name="comportamiento" class="form-control"
                                   value="{{ old('comportamiento', $mascota->comportamiento) }}">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Dueño</label>
                            <select name="dueno_id" class="form-control">
                                <option value="">-- Sin dueño registrado --</option>
                                @foreach($duenos as $dueno)
                                    <option value="{{ $dueno->id }}"
                                        {{ old('dueno_id', $mascota->dueno_id) == $dueno->id ? 'selected' : '' }}>
                                        {{ $dueno->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600 d-block">Estado</label>
                            <div class="custom-control custom-switch mt-2">
                                <input type="checkbox" class="custom-control-input"
                                       id="es_adoptado" name="es_adoptado" value="1"
                                       {{ old('es_adoptado', $mascota->es_adoptado) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="es_adoptado">Mascota adoptada</label>
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
                    <i class="fas fa-save mr-1"></i> Actualizar Mascota
                </button>
            </div>
        </div>
    </form>
@endsection
