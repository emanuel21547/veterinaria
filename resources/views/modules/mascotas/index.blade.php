@extends('layouts.main')
@section('titulo_pagina', 'Mascotas')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/usuarios.css') }}">
@endpush

@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4 page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-paw mr-2 text-primary"></i> Mascotas</h1>
            <p class="text-muted small mb-0">Pacientes registrados en el sistema.</p>
        </div>
        <a href="{{ route('mascotas.create') }}" class="btn btn-primary btn-sm shadow-sm mt-2 mt-sm-0">
            <i class="fas fa-plus mr-1"></i> Nueva Mascota
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show alert-session">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show alert-session">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="card card-usuarios shadow mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h6><i class="fas fa-table mr-2"></i> Listado de Mascotas</h6>
            <div class="input-group input-group-sm" style="width:250px;">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-0"><i class="fas fa-search text-primary"></i></span>
                </div>
                <input type="text" id="buscarMascota" class="form-control border-0 bg-white shadow-sm" placeholder="Buscar...">
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-usuarios mb-0" id="tablaMascotas">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Mascota</th>
                            <th>Especie / Raza</th>
                            <th>Dueño</th>
                            <th>Edad</th>
                            <th class="text-center">Consultas</th>
                            <th>Estado</th>
                            <th class="text-center" style="width:100px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mascotas as $itemMascota)
                            <tr>
                                <td class="text-center font-weight-bold text-primary small">
                                    #{{ $itemMascota->folioFormateado() }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar veterinario mr-2" style="font-size:1rem">
                                            {{ $itemMascota->emojiEspecie() }}
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $itemMascota->nombre }}</div>
                                            <small class="text-muted">{{ $itemMascota->tipo_sangre ?: '—' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="small">
                                    {{ $itemMascota->especie ?: '—' }}
                                    @if($itemMascota->raza)
                                        <span class="text-muted">/ {{ $itemMascota->raza }}</span>
                                    @endif
                                </td>
                                <td class="small">
                                    @if($itemMascota->dueno)
                                        <i class="fas fa-user text-primary mr-1"></i>
                                        {{ $itemMascota->dueno->nombre_completo }}
                                    @else
                                        <span class="text-muted"><i class="fas fa-question-circle mr-1"></i> Sin dueño</span>
                                    @endif
                                </td>
                                <td class="small">{{ $itemMascota->edadAnios() ?: '—' }}</td>
                                <td class="text-center">
                                    <span class="badge badge-rol badge-admin">{{ $itemMascota->consultas_count }}</span>
                                </td>
                                <td>
                                    @if($itemMascota->es_adoptado)
                                        <span class="badge badge-activo"><i class="fas fa-heart mr-1"></i> Adoptado</span>
                                    @else
                                        <span class="badge badge-inactivo" style="background:#f0f4ff;color:#4e73df;border-color:#b8c7ff;">
                                            <i class="fas fa-home mr-1"></i> Propio
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap:6px;">
                                        <a href="{{ route('mascotas.edit', $itemMascota) }}" class="btn btn-info btn-accion" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-accion"
                                                data-delete-form="form-del-{{ $itemMascota->id }}"
                                                data-user-name="{{ $itemMascota->nombre }}"
                                                title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <form id="form-del-{{ $itemMascota->id }}" action="{{ route('mascotas.destroy', $itemMascota) }}"
                                              method="POST" style="display:none;">
                                            @csrf @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-paw fa-3x text-gray-300 d-block mb-2"></i>
                                    No hay mascotas registradas.
                                    <a href="{{ route('mascotas.create') }}" class="d-block mt-2">
                                        <i class="fas fa-plus mr-1"></i> Registrar la primera
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($mascotas->hasPages())
                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                    <small class="text-muted">Mostrando {{ $mascotas->firstItem() }}–{{ $mascotas->lastItem() }} de {{ $mascotas->total() }}</small>
                    {{ $mascotas->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Modal eliminar --}}
    <div class="modal fade modal-delete" id="modalEliminar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle mr-2"></i> Confirmar eliminación</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-paw fa-3x text-danger mb-3"></i>
                    <p class="mb-1">¿Eliminar a <strong id="deleteUserName"></strong>?</p>
                    <small class="text-muted">Esta acción no se puede deshacer.</small>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-danger btn-sm" id="btnConfirmarEliminar">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/usuarios.js') }}"></script>
    <script>
        document.getElementById('buscarMascota')?.addEventListener('input', function () {
            const t = this.value.toLowerCase();
            document.querySelectorAll('#tablaMascotas tbody tr').forEach(r => {
                r.style.display = r.textContent.toLowerCase().includes(t) ? '' : 'none';
            });
        });
    </script>
@endpush
