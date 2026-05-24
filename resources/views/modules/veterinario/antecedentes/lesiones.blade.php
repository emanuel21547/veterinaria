@extends('layouts.main')
@section('titulo_pagina', 'Lesiones — ' . $mascota->nombre)

@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-band-aid mr-2 text-danger"></i> Lesiones de {{ $mascota->nombre }}
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
                <div class="card-header py-3" style="border-left: 4px solid #e74a3b;">
                    <h6 class="m-0 font-weight-bold text-danger">Nueva Lesión</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('veterinario.mascota.lesiones.store', $mascota) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="small font-weight-bold text-gray-600">Tipo de Lesión *</label>
                            <input type="text" name="tipo_lesion" class="form-control" required placeholder="Ej. Fractura pata trasera">
                        </div>
                        <button type="submit" class="btn btn-danger btn-block">Guardar</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">Historial de Lesiones</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Fecha de Registro</th>
                                    <th>Tipo de Lesión</th>
                                    <th width="80">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lesiones as $lesion)
                                    <tr>
                                        <td>{{ $lesion->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $lesion->tipo_lesion }}</td>
                                        <td>
                                            <form action="{{ route('veterinario.lesiones.destroy', $lesion) }}" method="POST" onsubmit="return confirm('¿Eliminar lesión?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted">No hay lesiones registradas.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
