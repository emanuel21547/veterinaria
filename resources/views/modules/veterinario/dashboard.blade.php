@extends('layouts.main')

@section('titulo_pagina', 'Dashboard — Veterinario')

@section('contenido')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-stethoscope mr-2 text-success"></i> Mi Panel
        </h1>
        <span class="text-muted small">
            <i class="fas fa-calendar-alt mr-1"></i> {{ now()->format('d/m/Y') }}
        </span>
    </div>

    {{-- Tarjetas de resumen --}}
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Consultas Hoy</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Diagnósticos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-microscope fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tratamientos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-pills fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pacientes Atendidos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-dog fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bienvenida veterinario --}}
    <div class="card shadow mb-4" style="border-left: 4px solid #1cc88a;">
        <div class="card-body d-flex align-items-center">
            <i class="fas fa-user-md fa-3x text-success mr-4"></i>
            <div>
                <h5 class="mb-1">
                    Hola, <strong>{{ Auth::user()->veterinario?->nombre_completo ?? Auth::user()->name }}</strong> 👋
                </h5>
                @if(Auth::user()->veterinario?->especialidad)
                    <span class="badge badge-success mb-1">
                        <i class="fas fa-stethoscope mr-1"></i>
                        {{ Auth::user()->veterinario->especialidad }}
                    </span>
                @endif
                <p class="text-muted mb-0 mt-1">
                    Bienvenido a tu panel de consultas. Usa el menú lateral para registrar diagnósticos, tratamientos y antecedentes de tus pacientes.
                </p>
            </div>
        </div>
    </div>

    {{-- Accesos rápidos --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">
                <i class="fas fa-bolt mr-2"></i> Accesos Rápidos
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 col-sm-4 col-6 mb-3 text-center">
                    <a href="{{ route('veterinario.diagnostico') }}" class="btn btn-outline-primary btn-sm w-100 py-3">
                        <i class="fas fa-microscope fa-2x d-block mb-1"></i>
                        <small>Diagnóstico</small>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-6 mb-3 text-center">
                    <a href="{{ route('veterinario.tratamiento') }}" class="btn btn-outline-success btn-sm w-100 py-3">
                        <i class="fas fa-pills fa-2x d-block mb-1"></i>
                        <small>Tratamiento</small>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-6 mb-3 text-center">
                    <a href="{{ route('veterinario.ant.alergias') }}" class="btn btn-outline-warning btn-sm w-100 py-3">
                        <i class="fas fa-allergies fa-2x d-block mb-1"></i>
                        <small>Alergias</small>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-6 mb-3 text-center">
                    <a href="{{ route('veterinario.ant.lesiones') }}" class="btn btn-outline-danger btn-sm w-100 py-3">
                        <i class="fas fa-band-aid fa-2x d-block mb-1"></i>
                        <small>Lesiones</small>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-6 mb-3 text-center">
                    <a href="{{ route('veterinario.ant.patologicas') }}" class="btn btn-outline-secondary btn-sm w-100 py-3">
                        <i class="fas fa-heartbeat fa-2x d-block mb-1"></i>
                        <small>Patológicas</small>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-6 mb-3 text-center">
                    <a href="{{ route('veterinario.hist.alimentacion') }}" class="btn btn-outline-info btn-sm w-100 py-3">
                        <i class="fas fa-bone fa-2x d-block mb-1"></i>
                        <small>Alimentación</small>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
