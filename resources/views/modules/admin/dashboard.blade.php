@extends('layouts.main')

@section('titulo_pagina', 'Dashboard — Administrador')

@section('contenido')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt mr-2 text-primary"></i> Dashboard
        </h1>
        <span class="text-muted small">
            <i class="fas fa-calendar-alt mr-1"></i> {{ now()->format('d/m/Y') }}
        </span>
    </div>

    {{-- Tarjetas de resumen --}}
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Usuarios</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\User::count() }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Veterinarios</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\User::where('rol','veterinario')->count() }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-user-md fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pacientes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-dog fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Citas Hoy</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-calendar-check fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bienvenida administrador --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-shield-alt mr-2"></i> Panel de Administración
            </h6>
        </div>
        <div class="card-body d-flex align-items-center">
            <i class="fas fa-user-shield fa-3x text-primary mr-4"></i>
            <div>
                <h5 class="mb-1">Hola, <strong>{{ Auth::user()->name }}</strong> 👋</h5>
                <p class="text-muted mb-0">
                    Tienes acceso completo al sistema. Usa el menú lateral para gestionar usuarios, pacientes, citas y configuración.
                </p>
            </div>
        </div>
    </div>

    {{-- Accesos rápidos --}}
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-bolt mr-2"></i> Accesos Rápidos</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-primary btn-sm mb-2 mr-2">
                        <i class="fas fa-users mr-1"></i> Gestionar Usuarios
                    </a>
                    <a href="{{ route('admin.usuarios.create') }}" class="btn btn-success btn-sm mb-2 mr-2">
                        <i class="fas fa-user-plus mr-1"></i> Nuevo Usuario
                    </a>
                    <a href="{{ route('admin.configuracion') }}" class="btn btn-secondary btn-sm mb-2">
                        <i class="fas fa-cogs mr-1"></i> Configuración
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-user-md mr-2"></i> Veterinarios Activos</h6>
                </div>
                <div class="card-body">
                    @php $vets = \App\Models\User::where('rol','veterinario')->where('activo', true)->with('veterinario')->get(); @endphp
                    @forelse($vets as $vet)
                        <div class="d-flex align-items-center mb-2">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mr-3"
                                 style="width:34px;height:34px;font-size:0.8rem;font-weight:700;">
                                {{ strtoupper(substr($vet->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="font-weight-bold small">{{ $vet->veterinario?->nombre_completo ?? $vet->name }}</div>
                                <div class="text-muted" style="font-size:0.75rem;">{{ $vet->veterinario?->especialidad ?? 'Sin especialidad' }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small mb-0"><i class="fas fa-info-circle mr-1"></i> No hay veterinarios registrados aún.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection
