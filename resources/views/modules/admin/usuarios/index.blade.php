@extends('layouts.main')

@section('titulo_pagina', 'Gestión de Usuarios')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/usuarios.css') }}">
@endpush

@section('contenido')

    {{-- ── Cabecera de página ─────────────────────────────────────── --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4 page-header">
        <div>
            <h1 class="page-title">
                <i class="fas fa-users-cog mr-2 text-primary"></i>
                Gestión de Usuarios
            </h1>
            <p class="text-muted small mb-0">Administra los usuarios del sistema: administradores y veterinarios.</p>
        </div>
        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary btn-sm shadow-sm mt-2 mt-sm-0">
            <i class="fas fa-user-plus mr-1"></i> Nuevo Usuario
        </a>
    </div>

    {{-- ── Alertas de sesión ──────────────────────────────────────── --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show alert-session" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show alert-session" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- ── Tarjetas de resumen ─────────────────────────────────────── --}}
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Usuarios</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usuarios->total() }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Administradores</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\User::where('rol','admin')->count() }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-user-shield fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-3">
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
    </div>

    {{-- ── Tabla principal ─────────────────────────────────────────── --}}
    <div class="card card-usuarios shadow mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h6><i class="fas fa-table mr-2"></i> Listado de Usuarios</h6>
            {{-- Búsqueda --}}
            <div class="filtros-bar mb-0 py-0 border-0 bg-transparent">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-0">
                            <i class="fas fa-search text-primary"></i>
                        </span>
                    </div>
                    <input type="text" id="buscarUsuario"
                           class="form-control border-0 bg-white shadow-sm"
                           placeholder="Buscar usuario...">
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-usuarios mb-0" id="tablaUsuarios">
                    <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Usuario</th>
                            <th>Correo Electrónico</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Datos Veterinario</th>
                            <th>Registro</th>
                            <th class="text-center" style="width:120px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usuarios as $usuario)
                            <tr>
                                {{-- # --}}
                                <td class="text-center text-muted small">{{ $loop->iteration }}</td>

                                {{-- Avatar + nombre --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar {{ $usuario->rol }} mr-3">
                                            {{ strtoupper(substr($usuario->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-gray-800">{{ $usuario->name }}</div>
                                            @if ($usuario->id === auth()->id())
                                                <small class="text-muted"><i class="fas fa-star text-warning"></i> Tú</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Email --}}
                                <td>
                                    <a href="mailto:{{ $usuario->email }}" class="text-dark">
                                        <i class="fas fa-envelope text-primary mr-1 small"></i>
                                        {{ $usuario->email }}
                                    </a>
                                </td>

                                {{-- Rol --}}
                                <td>
                                    @if ($usuario->rol === 'admin')
                                        <span class="badge badge-rol badge-admin">
                                            <i class="fas fa-user-shield mr-1"></i> Administrador
                                        </span>
                                    @else
                                        <span class="badge badge-rol badge-veterinario">
                                            <i class="fas fa-user-md mr-1"></i> Veterinario
                                        </span>
                                    @endif
                                </td>

                                {{-- Estado --}}
                                <td>
                                    @if ($usuario->activo)
                                        <span class="badge-activo">
                                            <i class="fas fa-circle mr-1" style="font-size:0.5rem"></i> Activo
                                        </span>
                                    @else
                                        <span class="badge-inactivo">
                                            <i class="fas fa-circle mr-1" style="font-size:0.5rem"></i> Inactivo
                                        </span>
                                    @endif
                                </td>

                                {{-- Datos veterinario --}}
                                <td>
                                    @if ($usuario->rol === 'veterinario' && $usuario->veterinario)
                                        <div class="small">
                                            <div class="font-weight-bold">{{ $usuario->veterinario->nombre_completo }}</div>
                                            @if ($usuario->veterinario->especialidad)
                                                <div class="text-muted">
                                                    <i class="fas fa-stethoscope mr-1"></i>
                                                    {{ $usuario->veterinario->especialidad }}
                                                </div>
                                            @endif
                                            @if ($usuario->veterinario->cedula_profesional)
                                                <div class="text-muted">
                                                    <i class="fas fa-id-card mr-1"></i>
                                                    Céd: {{ $usuario->veterinario->cedula_profesional }}
                                                </div>
                                            @endif
                                        </div>
                                    @elseif ($usuario->rol === 'admin')
                                        <span class="text-muted small">
                                            <i class="fas fa-minus mr-1"></i> N/A
                                        </span>
                                    @else
                                        <span class="text-warning small">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> Sin perfil
                                        </span>
                                    @endif
                                </td>

                                {{-- Fecha de registro --}}
                                <td class="small text-muted">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    {{ $usuario->created_at->format('d/m/Y') }}
                                </td>

                                {{-- Acciones --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1" style="gap: 6px;">
                                        {{-- Editar --}}
                                        <a href="{{ route('admin.usuarios.edit', $usuario) }}"
                                           class="btn btn-info btn-accion"
                                           title="Editar usuario">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Eliminar --}}
                                        @if ($usuario->id !== auth()->id())
                                            <button type="button"
                                                    class="btn btn-danger btn-accion"
                                                    data-delete-form="form-delete-{{ $usuario->id }}"
                                                    data-user-name="{{ $usuario->name }}"
                                                    title="Eliminar usuario">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                            <form id="form-delete-{{ $usuario->id }}"
                                                  action="{{ route('admin.usuarios.destroy', $usuario) }}"
                                                  method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @else
                                            <button class="btn btn-secondary btn-accion" disabled title="No puedes eliminarte a ti mismo">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-3x mb-3 d-block text-gray-300"></i>
                                        No hay usuarios registrados.
                                        <a href="{{ route('admin.usuarios.create') }}" class="d-block mt-2">
                                            <i class="fas fa-plus mr-1"></i> Crear el primero
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if ($usuarios->hasPages())
                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                    <small class="text-muted">
                        Mostrando {{ $usuarios->firstItem() }} – {{ $usuarios->lastItem() }}
                        de {{ $usuarios->total() }} usuarios
                    </small>
                    {{ $usuarios->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- ── Modal confirmación eliminar ────────────────────────────── --}}
    <div class="modal fade modal-delete" id="modalEliminar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Confirmar eliminación
                    </h5>
                    <button class="close" type="button" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-user-times fa-3x text-danger mb-3"></i>
                    <p class="mb-1">¿Estás seguro de eliminar a</p>
                    <p class="font-weight-bold text-dark mb-0" id="deleteUserName"></p>
                    <small class="text-muted">Esta acción no se puede deshacer.</small>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <button class="btn btn-danger btn-sm" id="btnConfirmarEliminar">
                        <i class="fas fa-trash-alt mr-1"></i> Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/admin/usuarios.js') }}"></script>
@endpush
