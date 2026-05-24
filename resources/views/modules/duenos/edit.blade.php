@extends('layouts.main')
@section('titulo_pagina', 'Editar Dueño')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/usuarios.css') }}">
@endpush

@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4 page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-user-edit mr-2 text-primary"></i> Editar Dueño</h1>
            <p class="text-muted small mb-0">
                <a href="{{ route('duenos.index') }}" class="text-muted"><i class="fas fa-arrow-left mr-1"></i> Volver al listado</a>
            </p>
        </div>
        <div class="d-flex align-items-center">
            <div class="user-avatar admin mr-2" style="width:44px;height:44px;font-size:1rem;">
                {{ strtoupper(substr($dueno->nombre_completo, 0, 2)) }}
            </div>
            <div>
                <div class="font-weight-bold">{{ $dueno->nombre_completo }}</div>
                <small class="text-muted">{{ $dueno->mascotas()->count() }} mascota(s)</small>
            </div>
        </div>
    </div>

    <form action="{{ route('duenos.update', $dueno) }}" method="POST" novalidate>
        @csrf @method('PUT')
        <div class="card card-usuarios shadow mb-4">
            <div class="card-header"><h6><i class="fas fa-user-edit mr-2"></i> Datos del Dueño</h6></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">
                                Nombre Completo <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nombre_completo"
                                   class="form-control @error('nombre_completo') is-invalid @enderror"
                                   value="{{ old('nombre_completo', $dueno->nombre_completo) }}" required>
                            @error('nombre_completo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Teléfono</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone text-primary"></i></span>
                                </div>
                                <input type="text" name="telefono"
                                       class="form-control @error('telefono') is-invalid @enderror"
                                       value="{{ old('telefono', $dueno->telefono) }}">
                                @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Dirección</label>
                            <textarea name="direccion" rows="2"
                                      class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion', $dueno->direccion) }}</textarea>
                            @error('direccion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Redes Sociales</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-hashtag text-info"></i></span>
                                </div>
                                <input type="text" name="redes_sociales"
                                       class="form-control @error('redes_sociales') is-invalid @enderror"
                                       value="{{ old('redes_sociales', $dueno->redes_sociales) }}">
                                @error('redes_sociales')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('duenos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-1"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Actualizar Dueño
                </button>
            </div>
        </div>
    </form>
@endsection
