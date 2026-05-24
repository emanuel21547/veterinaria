@extends('layouts.main')
@section('titulo_pagina', 'Alergias — ' . $mascota->nombre)

@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-allergies mr-2 text-warning"></i> Alergias de {{ $mascota->nombre }}
            </h1>
            <small class="text-muted">Expediente Clínico · {{ $mascota->emojiEspecie() }}</small>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="row">
        {{-- Formulario para agregar --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3" style="border-left: 4px solid #f6c23e;">
                    <h6 class="m-0 font-weight-bold text-warning">Nueva Alergia</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('veterinario.mascota.alergias.store', $mascota) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="small font-weight-bold text-gray-600">Sustancia Alérgena *</label>
                            <input type="text" name="sustancia_alergena" class="form-control" required placeholder="Ej. Penicilina">
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold text-gray-600">Reacción (Opcional)</label>
                            <textarea name="reaccion" rows="2" class="form-control" placeholder="Ej. Erupción cutánea"></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning btn-block">Guardar</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Lista de Alergias --}}
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">Historial de Alergias</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Sustancia</th>
                                    <th>Reacción</th>
                                    <th width="80">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($alergias as $alergia)
                                    <tr>
                                        <td>{{ $alergia->created_at->format('d/m/Y') }}</td>
                                        <td class="font-weight-bold text-danger">{{ $alergia->sustancia_alergena }}</td>
                                        <td>{{ $alergia->reaccion ?: '-' }}</td>
                                        <td>
                                            <form action="{{ route('veterinario.alergias.destroy', $alergia) }}" method="POST" onsubmit="return confirm('¿Eliminar alergia?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted">No hay alergias registradas.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
