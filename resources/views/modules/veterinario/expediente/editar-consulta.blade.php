@extends('layouts.main')
@section('titulo_pagina', 'Editar Consulta')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/veterinario/expediente.css') }}">
@endpush

@section('contenido')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('veterinario.mascota.consultas', $consulta->mascota) }}" class="btn btn-outline-secondary btn-sm mr-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-edit mr-2 text-success"></i> Editar Consulta
                </h1>
                <small class="text-muted">
                    Paciente: {{ $consulta->mascota->emojiEspecie() }} <strong>{{ $consulta->mascota->nombre }}</strong>
                    · {{ $consulta->fecha_consulta->format('d/m/Y H:i') }}
                </small>
            </div>
        </div>
    </div>

    <form action="{{ route('veterinario.consulta.actualizar', $consulta) }}" method="POST" novalidate>
        @csrf @method('PUT')

        <div class="card shadow mb-4">
            <div class="card-header py-3" style="border-left: 4px solid #1cc88a;">
                <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-clipboard mr-2"></i> Datos Generales</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Fecha y Hora <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="fecha_consulta"
                                   class="form-control @error('fecha_consulta') is-invalid @enderror"
                                   value="{{ old('fecha_consulta', $consulta->fecha_consulta->format('Y-m-d\TH:i')) }}" required>
                            @error('fecha_consulta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Peso (kg)</label>
                            <div class="input-group">
                                <input type="number" name="peso" step="0.01" min="0" class="form-control"
                                       value="{{ old('peso', $consulta->peso) }}">
                                <div class="input-group-append"><span class="input-group-text">kg</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Talla (cm)</label>
                            <div class="input-group">
                                <input type="number" name="talla" step="0.1" min="0" class="form-control"
                                       value="{{ old('talla', $consulta->talla) }}">
                                <div class="input-group-append"><span class="input-group-text">cm</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3" style="border-left: 4px solid #4e73df;">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-stethoscope mr-2"></i> Diagnóstico y Tratamiento</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600"><i class="fas fa-microscope mr-1 text-primary"></i> Diagnóstico</label>
                            <textarea name="diagnostico" id="diagnostico" rows="10" class="form-control">{{ old('diagnostico', $consulta->diagnostico) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600"><i class="fas fa-pills mr-1 text-success"></i> Tratamiento</label>
                            <textarea name="tratamiento" id="tratamiento" rows="10" class="form-control">{{ old('tratamiento', $consulta->tratamiento) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="d-flex justify-content-between mb-4">
            <a href="{{ route('veterinario.mascota.consultas', $consulta->mascota) }}" class="btn btn-secondary">
                <i class="fas fa-times mr-1"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-success px-4">
                <i class="fas fa-save mr-1"></i> Actualizar Consulta
            </button>
        </div>
    </form>

@endsection

@push('scripts')
    <!-- CKEditor 5 Classic -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            ClassicEditor
                .create(document.querySelector('#diagnostico'))
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector('#tratamiento'))
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }
    </style>
@endpush
