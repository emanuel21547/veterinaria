@extends('layouts.main')
@section('titulo_pagina', 'Configuración del Sistema')

@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-cogs mr-2 text-secondary"></i> Configuración del Sistema
        </h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <form action="{{ route('admin.configuracion.update') }}" method="POST">
        @csrf @method('PUT')

        <div class="card shadow mb-4">
            <div class="card-header py-3" style="border-left: 4px solid #858796;">
                <h6 class="m-0 font-weight-bold text-secondary">
                    <i class="fas fa-building mr-2"></i> Datos de la Clínica
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="small font-weight-bold text-gray-600">Nombre de la Clínica</label>
                        <input type="text" name="nombre_clinica" class="form-control" value="{{ old('nombre_clinica', $configuracion->nombre_clinica) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small font-weight-bold text-gray-600">Teléfono de Contacto</label>
                        <input type="text" name="telefono_contacto" class="form-control" value="{{ old('telefono_contacto', $configuracion->telefono_contacto) }}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="small font-weight-bold text-gray-600">Dirección Física</label>
                        <textarea name="direccion_fisica" rows="2" class="form-control">{{ old('direccion_fisica', $configuracion->direccion_fisica) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3" style="border-left: 4px solid #4e73df;">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-book-open mr-2"></i> Identidad y Filosofía
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="small font-weight-bold text-gray-600">Misión</label>
                        <textarea name="mision" rows="4" class="form-control">{{ old('mision', $configuracion->mision) }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small font-weight-bold text-gray-600">Visión</label>
                        <textarea name="vision" rows="4" class="form-control">{{ old('vision', $configuracion->vision) }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small font-weight-bold text-gray-600">Valores</label>
                        <textarea name="valores" rows="4" class="form-control">{{ old('valores', $configuracion->valores) }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small font-weight-bold text-gray-600">Historia</label>
                        <textarea name="historia" rows="4" class="form-control">{{ old('historia', $configuracion->historia) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-4">
            <button type="submit" class="btn btn-secondary px-4">
                <i class="fas fa-save mr-1"></i> Guardar Cambios
            </button>
        </div>
    </form>
@endsection
