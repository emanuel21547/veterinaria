@extends('layouts.main')
@section('titulo_pagina', 'Dueños')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/usuarios.css') }}">
@endpush

@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4 page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-users mr-2 text-primary"></i> Dueños de Mascotas</h1>
            <p class="text-muted small mb-0">Gestión de propietarios registrados en el sistema.</p>
        </div>
        <a href="{{ route('duenos.create') }}" class="btn btn-primary btn-sm shadow-sm mt-2 mt-sm-0">
            <i class="fas fa-user-plus mr-1"></i> Nuevo Dueño
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
            <h6><i class="fas fa-table mr-2"></i> Listado de Dueños</h6>
            <div class="input-group input-group-sm" style="width:250px;">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-0"><i class="fas fa-search text-primary"></i></span>
                </div>
                <input type="text" id="buscarDueno" class="form-control border-0 bg-white shadow-sm" placeholder="Buscar...">
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-usuarios mb-0" id="tablaDuenos">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre Completo</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Redes Sociales</th>
                            <th class="text-center">Mascotas</th>
                            <th class="text-center" style="width:100px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($duenos as $dueno)
                            <tr>
                                <td class="text-center text-muted small">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar admin mr-2">{{ strtoupper(substr($dueno->nombre_completo, 0, 2)) }}</div>
                                        <strong>{{ $dueno->nombre_completo }}</strong>
                                    </div>
                                </td>
                                <td>
                                    @if($dueno->telefono)
                                        <i class="fas fa-phone text-success mr-1 small"></i> {{ $dueno->telefono }}
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td class="small">{{ Str::limit($dueno->direccion, 40) ?: '—' }}</td>
                                <td class="small">{{ $dueno->redes_sociales ?: '—' }}</td>
                                <td class="text-center">
                                    <span class="badge badge-rol badge-veterinario">
                                        <i class="fas fa-paw mr-1"></i> {{ $dueno->mascotas_count }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap:6px;">
                                        <a href="{{ route('duenos.edit', $dueno) }}" class="btn btn-info btn-accion" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-accion"
                                                data-delete-form="form-del-{{ $dueno->id }}"
                                                data-user-name="{{ $dueno->nombre_completo }}"
                                                title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <form id="form-del-{{ $dueno->id }}" action="{{ route('duenos.destroy', $dueno) }}"
                                              method="POST" style="display:none;">
                                            @csrf @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-users fa-3x text-gray-300 d-block mb-2"></i>
                                    No hay dueños registrados.
                                    <a href="{{ route('duenos.create') }}" class="d-block mt-2">
                                        <i class="fas fa-plus mr-1"></i> Registrar el primero
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($duenos->hasPages())
                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                    <small class="text-muted">Mostrando {{ $duenos->firstItem() }}–{{ $duenos->lastItem() }} de {{ $duenos->total() }}</small>
                    {{ $duenos->links() }}
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
                    <i class="fas fa-user-times fa-3x text-danger mb-3"></i>
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
        // Búsqueda en tabla
        document.getElementById('buscarDueno')?.addEventListener('input', function () {
            const t = this.value.toLowerCase();
            document.querySelectorAll('#tablaDuenos tbody tr').forEach(r => {
                r.style.display = r.textContent.toLowerCase().includes(t) ? '' : 'none';
            });
        });
    </script>
@endpush
