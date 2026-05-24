@extends('layouts.main')
@section('titulo_pagina', 'Nuevo Dueño')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/usuarios.css') }}">
@endpush

@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4 page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-user-plus mr-2 text-primary"></i> Nuevo Dueño</h1>
            <p class="text-muted small mb-0">
                <a href="{{ route('duenos.index') }}" class="text-muted"><i class="fas fa-arrow-left mr-1"></i> Volver al listado</a>
            </p>
        </div>
    </div>

    <form action="{{ route('duenos.store') }}" method="POST" novalidate>
        @csrf
        <div class="card card-usuarios shadow mb-4">
            <div class="card-header"><h6><i class="fas fa-user mr-2"></i> Datos del Dueño</h6></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">
                                Nombre Completo <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nombre_completo"
                                   class="form-control @error('nombre_completo') is-invalid @enderror"
                                   value="{{ old('nombre_completo') }}" placeholder="Nombre completo" required>
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
                                       value="{{ old('telefono') }}" placeholder="Ej. 5551234567">
                                @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Dirección</label>
                            <textarea name="direccion" rows="2"
                                      class="form-control @error('direccion') is-invalid @enderror"
                                      placeholder="Calle, número, colonia...">{{ old('direccion') }}</textarea>
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
                                       value="{{ old('redes_sociales') }}" placeholder="@usuario o URL">
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
                    <i class="fas fa-save mr-1"></i> Guardar Dueño
                </button>
            </div>
        </div>
    </form>
@endsection
