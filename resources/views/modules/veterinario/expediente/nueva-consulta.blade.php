@extends('layouts.main')
@section('titulo_pagina', 'Nueva Consulta — ' . $mascota->nombre)
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/veterinario/expediente.css') }}">
@endpush

@section('contenido')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('veterinario.mascota.consultas', $mascota) }}" class="btn btn-outline-secondary btn-sm mr-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-plus-circle mr-2 text-success"></i> Nueva Consulta
                </h1>
                <small class="text-muted">
                    Paciente: {{ $mascota->emojiEspecie() }} <strong>{{ $mascota->nombre }}</strong>
                    (Folio #{{ $mascota->folioFormateado() }})
                </small>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <form action="{{ route('veterinario.consulta.guardar') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="mascota_id" value="{{ $mascota->id }}">

        {{-- ── Datos generales ─────────────────────────────────── --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="border-left: 4px solid #1cc88a;">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-clipboard mr-2"></i> Datos Generales de la Consulta
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">
                                Fecha y Hora <span class="text-danger">*</span>
                            </label>
                            <input type="datetime-local" name="fecha_consulta"
                                   class="form-control @error('fecha_consulta') is-invalid @enderror"
                                   value="{{ old('fecha_consulta', now()->format('Y-m-d\TH:i')) }}" required>
                            @error('fecha_consulta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Peso (kg)</label>
                            <div class="input-group">
                                <input type="number" name="peso" step="0.01" min="0"
                                       class="form-control @error('peso') is-invalid @enderror"
                                       value="{{ old('peso') }}" placeholder="Ej. 12.5">
                                <div class="input-group-append">
                                    <span class="input-group-text">kg</span>
                                </div>
                                @error('peso')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">Talla (cm)</label>
                            <div class="input-group">
                                <input type="number" name="talla" step="0.1" min="0"
                                       class="form-control @error('talla') is-invalid @enderror"
                                       value="{{ old('talla') }}" placeholder="Ej. 45">
                                <div class="input-group-append">
                                    <span class="input-group-text">cm</span>
                                </div>
                                @error('talla')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Diagnóstico y Tratamiento ────────────────────────── --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3" style="border-left: 4px solid #4e73df;">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-stethoscope mr-2"></i> Diagnóstico y Tratamiento
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">
                                <i class="fas fa-microscope mr-1 text-primary"></i> Diagnóstico
                            </label>
                            <textarea name="diagnostico" id="diagnostico" rows="10"
                                      class="form-control @error('diagnostico') is-invalid @enderror"
                                      placeholder="Describe el diagnóstico detallado (puedes usar formato)...">{{ old('diagnostico') }}</textarea>
                            @error('diagnostico')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold small text-uppercase text-gray-600">
                                <i class="fas fa-pills mr-1 text-success"></i> Tratamiento
                            </label>
                            <textarea name="tratamiento" id="tratamiento" rows="10"
                                      class="form-control @error('tratamiento') is-invalid @enderror"
                                      placeholder="Medicamentos, dosis, indicaciones (puedes usar formato)...">{{ old('tratamiento') }}</textarea>
                            @error('tratamiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>



        {{-- Botones --}}
        <div class="d-flex justify-content-between mb-4">
            <a href="{{ route('veterinario.mascota.consultas', $mascota) }}" class="btn btn-secondary">
                <i class="fas fa-times mr-1"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-success px-4">
                <i class="fas fa-save mr-1"></i> Guardar Consulta
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
