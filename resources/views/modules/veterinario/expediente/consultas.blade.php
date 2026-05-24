@extends('layouts.main')
@section('titulo_pagina', 'Historial — ' . $mascota->nombre)
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/veterinario/expediente.css') }}">
@endpush

@section('contenido')

    {{-- Encabezado --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm mr-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    {{ $mascota->emojiEspecie() }} {{ $mascota->nombre }}
                </h1>
                <small class="text-muted">Folio #{{ $mascota->folioFormateado() }} · Historial de Consultas</small>
            </div>
        </div>
        <a href="{{ route('veterinario.consulta.crear', $mascota) }}" class="btn btn-success btn-sm shadow-sm mt-2 mt-sm-0">
            <i class="fas fa-plus mr-1"></i> Nueva Consulta
        </a>
    </div>

    {{-- Alerta éxito --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- Ficha de la mascota --}}
    <div class="ficha-mascota mb-4">
        <div class="row align-items-center">
            <div class="col-auto">
                <div class="mascota-sel-avatar" style="width:56px;height:56px;font-size:1.8rem;background:#1cc88a;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    {{ $mascota->emojiEspecie() }}
                </div>
            </div>
            <div class="col">
                <h5 class="font-weight-bold mb-0 text-success">{{ $mascota->nombre }}</h5>
                <div class="text-muted small mt-1">
                    @if($mascota->especie) <span class="mr-3"><i class="fas fa-paw mr-1"></i>{{ $mascota->especie }}{{ $mascota->raza ? ' · ' . $mascota->raza : '' }}</span> @endif
                    @if($mascota->edadAnios()) <span class="mr-3"><i class="fas fa-birthday-cake mr-1"></i>{{ $mascota->edadAnios() }}</span> @endif
                    @if($mascota->tipo_sangre) <span class="mr-3"><i class="fas fa-tint mr-1"></i>{{ $mascota->tipo_sangre }}</span> @endif
                    @if($mascota->es_adoptado) <span class="badge badge-success"><i class="fas fa-heart mr-1"></i>Adoptado</span> @endif
                </div>
            </div>
            <div class="col-auto text-right">
                @if($mascota->dueno)
                    <div class="font-weight-bold small"><i class="fas fa-user text-success mr-1"></i> {{ $mascota->dueno->nombre_completo }}</div>
                    @if($mascota->dueno->telefono)
                        <div class="text-muted" style="font-size:0.8rem;"><i class="fas fa-phone mr-1"></i>{{ $mascota->dueno->telefono }}</div>
                    @endif
                @else
                    <span class="text-muted small"><i class="fas fa-question-circle mr-1"></i> Sin dueño registrado</span>
                @endif
                <div class="mt-1">
                    <a href="{{ route('mascotas.edit', $mascota) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-edit mr-1"></i> Editar
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Historial de consultas --}}
    @if($consultas->isEmpty())
        <div class="card shadow">
            <div class="card-body text-center py-5">
                <i class="fas fa-clipboard fa-3x text-gray-300 mb-3"></i>
                <h5 class="text-gray-700">Sin consultas registradas</h5>
                <p class="text-muted">Esta mascota aún no tiene consultas en el sistema.</p>
                <a href="{{ route('veterinario.consulta.crear', $mascota) }}" class="btn btn-success">
                    <i class="fas fa-plus mr-1"></i> Registrar Primera Consulta
                </a>
            </div>
        </div>
    @else
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="font-weight-bold text-gray-700 mb-0">
                <i class="fas fa-clipboard-list mr-2 text-success"></i>
                {{ $consultas->count() }} consulta(s) registrada(s)
            </h5>
        </div>

        @foreach($consultas as $consulta)
            <div class="consulta-card card">
                {{-- Header de la consulta --}}
                <div class="consulta-header" data-toggle="collapse"
                     data-target="#consulta-{{ $consulta->id }}"
                     aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mr-3"
                                 style="width:36px;height:36px;flex-shrink:0;">
                                <i class="fas fa-stethoscope" style="font-size:0.85rem;"></i>
                            </div>
                            <div>
                                <div class="font-weight-bold text-gray-800">
                                    Consulta del {{ $consulta->fecha_consulta->format('d/m/Y') }}
                                    <small class="text-muted ml-2">{{ $consulta->fecha_consulta->format('H:i') }}h</small>
                                </div>
                                <div class="text-muted" style="font-size:0.8rem;">
                                    <i class="fas fa-user-md mr-1"></i>
                                    {{ $consulta->veterinario?->nombre_completo ?? $consulta->veterinario?->usuario?->name ?? 'Veterinario' }}
                                    @if($consulta->peso) · <i class="fas fa-weight-hanging mr-1"></i>{{ $consulta->peso }} kg @endif
                                    @if($consulta->talla) · {{ $consulta->talla }} cm @endif
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center" style="gap:8px;">
                            <a href="{{ route('veterinario.consulta.editar', $consulta) }}"
                               class="btn btn-sm btn-outline-success"
                               onclick="event.stopPropagation()">
                                <i class="fas fa-edit"></i>
                            </a>
                            <i class="fas fa-chevron-down text-muted"></i>
                        </div>
                    </div>
                </div>

                {{-- Cuerpo expandible --}}
                <div id="consulta-{{ $consulta->id }}"
                     class="collapse {{ $loop->first ? 'show' : '' }}">
                    <div class="consulta-body">
                        <div class="row">

                            @if($consulta->diagnostico)
                            <div class="col-md-6">
                                <div class="seccion-clinica">
                                    <div class="seccion-titulo"><i class="fas fa-microscope mr-1"></i> Diagnóstico</div>
                                    <div class="mb-0 small ck-content">{!! $consulta->diagnostico !!}</div>
                                </div>
                            </div>
                            @endif

                            @if($consulta->tratamiento)
                            <div class="col-md-6">
                                <div class="seccion-clinica verde">
                                    <div class="seccion-titulo"><i class="fas fa-pills mr-1"></i> Tratamiento</div>
                                    <div class="mb-0 small ck-content">{!! $consulta->tratamiento !!}</div>
                                </div>
                            </div>
                            @endif



                            @if(!$consulta->diagnostico && !$consulta->tratamiento)
                                <div class="col-12">
                                    <p class="text-muted small text-center mb-0">
                                        <i class="fas fa-info-circle mr-1"></i> Esta consulta no tiene información clínica registrada.
                                        <a href="{{ route('veterinario.consulta.editar', $consulta) }}">Completar ahora</a>
                                    </p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection

@push('scripts')
    <link rel="stylesheet" href="{{ asset('css/veterinario/expediente.css') }}">
@endpush
