@extends('layouts.main')
@section('titulo_pagina', 'Patologías — ' . $mascota->nombre)

@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-heartbeat mr-2 text-info"></i> Patológicas de {{ $mascota->nombre }}
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
                <div class="card-header py-3" style="border-left: 4px solid #36b9cc;">
                    <h6 class="m-0 font-weight-bold text-info">Nueva Patología</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('veterinario.mascota.patologicas.store', $mascota) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="small font-weight-bold text-gray-600">Enfermedad / Condición *</label>
                            <input type="text" name="enfermedad" class="form-control" required placeholder="Ej. Diabetes">
                        </div>
                        <div class="form-group custom-control custom-checkbox">
                            <input type="checkbox" name="es_cronica" class="custom-control-input" id="es_cronica" value="1">
                            <label class="custom-control-label small font-weight-bold" for="es_cronica">Es enfermedad crónica</label>
                        </div>
                        <button type="submit" class="btn btn-info btn-block mt-3">Guardar</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-800">Historial Patológico</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Enfermedad</th>
                                    <th>Tipo</th>
                                    <th width="80">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patologias as $patologia)
                                    <tr>
                                        <td>{{ $patologia->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $patologia->enfermedad }}</td>
                                        <td>
                                            @if($patologia->es_cronica)
                                                <span class="badge badge-warning">Crónica</span>
                                            @else
                                                <span class="badge badge-secondary">Regular</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('veterinario.patologicas.destroy', $patologia) }}" method="POST" onsubmit="return confirm('¿Eliminar patología?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted">No hay patologías registradas.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
