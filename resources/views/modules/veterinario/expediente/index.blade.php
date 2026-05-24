@extends('layouts.main')
@section('titulo_pagina', 'Expedientes Médicos')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/veterinario/expediente.css') }}">
@endpush

@section('contenido')

    {{-- Encabezado --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-folder-open mr-2 text-success"></i> Gestión de Expedientes
        </h1>
        <div class="d-flex" style="gap: 0.5rem;">
            <a href="{{ route('mascotas.create') }}" class="btn btn-success btn-sm shadow-sm">
                <i class="fas fa-plus mr-1"></i> Nueva Mascota
            </a>
            <a href="{{ route('duenos.create') }}" class="btn btn-outline-success btn-sm shadow-sm">
                <i class="fas fa-user-plus mr-1"></i> Nuevo Dueño
            </a>
        </div>
    </div>

    {{-- Card del Buscador --}}
    <div class="card card-expediente shadow mb-4">
        <div class="card-header">
            <h6>
                <i class="fas fa-folder-open mr-2"></i> Expedientes Médicos
            </h6>
        </div>
        <div class="card-body p-4">

            <p class="buscador-titulo">Buscar Expediente</p>
            <p class="text-center text-muted small mb-4">
                Escribe el nombre de la mascota o del dueño para encontrar el expediente
            </p>

            {{-- Campo de búsqueda --}}
            <div class="buscador-input-wrapper mb-3">
                <input
                    type="text"
                    id="buscadorExpediente"
                    class="buscador-input"
                    placeholder="Ej: Firulais, Max, Juan García..."
                    autocomplete="off"
                    data-search-url="{{ route('veterinario.buscar') }}"
                >
                <i class="fas fa-search buscador-icon"></i>
                <div class="buscador-spinner" id="buscadorSpinner">
                    <div class="spinner-border spinner-border-sm text-success" role="status">
                        <span class="sr-only">Buscando...</span>
                    </div>
                </div>

                {{-- Dropdown de resultados --}}
                <div class="resultados-dropdown" id="resultadosDropdown"></div>
            </div>

            {{-- Mascota seleccionada (aparece tras elegir del dropdown) --}}
            <div class="mascota-seleccionada" id="mascotaSeleccionada">
                <div class="mascota-sel-avatar" id="selEmoji">🐾</div>
                <div class="mascota-sel-info">
                    <div class="mascota-sel-nombre">
                        <i class="fas fa-check-circle mr-1"></i>
                        Seleccionado: <span id="selNombre"></span>
                    </div>
                    <div class="mascota-sel-detalle" id="selDetalle"></div>
                </div>
                <button type="button" id="btnLimpiarSeleccion" class="btn btn-sm btn-light ml-auto" title="Limpiar">
                    <i class="fas fa-times text-muted"></i>
                </button>
            </div>

            {{-- Acciones (aparecen tras seleccionar) --}}
            <div class="expediente-acciones" id="expedienteAcciones">
                <a href="#" id="btnVerConsultas" class="btn btn-success btn-expediente"
                   data-nueva-url="{{ route('mascotas.create') }}">
                    <i class="fas fa-clipboard-list"></i> Ver Consultas
                </a>
                <a href="{{ route('mascotas.create') }}" id="btnNuevaMascota"
                   class="btn btn-outline-success btn-expediente">
                    <i class="fas fa-plus-circle"></i> Nuevo Paciente / Mascota
                </a>
            </div>

        </div>
    </div>

    {{-- Últimas mascotas registradas (acceso rápido) --}}
    @php
        $recientes = \App\Models\Mascota::with('dueno')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
    @endphp

    @if($recientes->count())
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">
                <i class="fas fa-history mr-2"></i> Pacientes Recientes
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Folio</th>
                            <th>Mascota</th>
                            <th>Especie</th>
                            <th>Dueño</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recientes as $m)
                        <tr>
                            <td class="font-weight-bold text-success small">#{{ $m->folioFormateado() }}</td>
                            <td>
                                <span class="mr-1">{{ $m->emojiEspecie() }}</span>
                                <strong>{{ $m->nombre }}</strong>
                            </td>
                            <td class="small text-muted">{{ $m->especie ?: '—' }}</td>
                            <td class="small">
                                {{ $m->dueno?->nombre_completo ?? 'Sin dueño' }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('veterinario.mascota.consultas', $m) }}"
                                   class="btn btn-sm btn-success">
                                    <i class="fas fa-clipboard-list mr-1"></i> Consultas
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

@endsection

@push('scripts')
    <script src="{{ asset('js/veterinario/expediente.js') }}"></script>
@endpush
