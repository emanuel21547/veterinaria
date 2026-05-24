@extends('layouts.main')
@section('titulo_pagina', 'Historial Alimentación — ' . $mascota->nombre)

@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-bone mr-2 text-success"></i> Alimentación de {{ $mascota->nombre }}
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
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3" style="border-left: 4px solid #1cc88a;">
                    <h6 class="m-0 font-weight-bold text-success">Nuevo Registro</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('veterinario.mascota.alimentacion.store', $mascota) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="small font-weight-bold text-gray-600">Descripción de Dieta *</label>
                            <textarea name="descripcion_dieta" rows="3" class="form-control" required placeholder="Ej. Croquetas premium marca X, pollo hervido..."></textarea>
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold text-gray-600">Frecuencia Diaria (Opcional)</label>
                            <div class="input-group">
                                <input type="number" name="frecuencia_diaria" class="form-control" placeholder="Ej. 2">
                                <div class="input-group-append"><span class="input-group-text">veces/día</span></div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-block mt-3">Guardar</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">Historial</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Dieta</th>
                                    <th>Frecuencia</th>
                                    <th width="80">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($alimentacion as $alimento)
                                    <tr>
                                        <td>{{ $alimento->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $alimento->descripcion_dieta }}</td>
                                        <td>{{ $alimento->frecuencia_diaria ? $alimento->frecuencia_diaria . ' al día' : '-' }}</td>
                                        <td>
                                            <form action="{{ route('veterinario.alimentacion.destroy', $alimento) }}" method="POST" onsubmit="return confirm('¿Eliminar registro?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted">No hay historial registrado.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
