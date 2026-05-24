@extends('layouts.main')
@section('titulo_pagina', 'Antecedentes — Lesiones')
@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-band-aid mr-2 text-danger"></i> Antecedentes — Lesiones</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="border-left: 4px solid #e74a3b;">
            <h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-band-aid mr-2"></i> Módulo de Lesiones</h6>
        </div>
        <div class="card-body text-center py-5">
            <i class="fas fa-band-aid fa-4x text-gray-300 mb-3"></i>
            <h5 class="text-gray-700 font-weight-bold">Módulo en construcción</h5>
            <p class="text-muted mb-4">Aquí registrarás los antecedentes de lesiones de los pacientes.</p>
            <a href="{{ route('home') }}" class="btn btn-danger btn-sm"><i class="fas fa-arrow-left mr-1"></i> Volver al Dashboard</a>
        </div>
    </div>
@endsection
