@extends('layouts.main')
@section('titulo_pagina', 'Antecedentes — Patológicas')
@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-heartbeat mr-2 text-secondary"></i> Antecedentes — Patológicas</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="border-left: 4px solid #858796;">
            <h6 class="m-0 font-weight-bold text-secondary"><i class="fas fa-heartbeat mr-2"></i> Módulo de Patológicas</h6>
        </div>
        <div class="card-body text-center py-5">
            <i class="fas fa-heartbeat fa-4x text-gray-300 mb-3"></i>
            <h5 class="text-gray-700 font-weight-bold">Módulo en construcción</h5>
            <p class="text-muted mb-4">Aquí registrarás los antecedentes patológicos de los pacientes.</p>
            <a href="{{ route('home') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left mr-1"></i> Volver al Dashboard</a>
        </div>
    </div>
@endsection
