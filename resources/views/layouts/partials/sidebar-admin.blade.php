{{-- ============================================================
     SIDEBAR ADMINISTRADOR
     ============================================================ --}}
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Logo --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-paw"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Veterinaria</div>
    </a>

    <hr class="sidebar-divider my-0">

    {{-- Dashboard --}}
    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    {{-- ── Clínica ─────────────────────────────────────────────── --}}
    <div class="sidebar-heading">Clínica</div>

    {{-- Dueños --}}
    <li class="nav-item {{ request()->routeIs('duenos.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDuenos"
            aria-expanded="false" aria-controls="collapseDuenos">
            <i class="fas fa-fw fa-users"></i>
            <span>Dueños</span>
        </a>
        <div id="collapseDuenos" class="collapse {{ request()->routeIs('duenos.*') ? 'show' : '' }}"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestión de Dueños:</h6>
                <a class="collapse-item {{ request()->routeIs('duenos.index') ? 'active' : '' }}" href="{{ route('duenos.index') }}">Listar Dueños</a>
                <a class="collapse-item {{ request()->routeIs('duenos.create') ? 'active' : '' }}" href="{{ route('duenos.create') }}">Nuevo Dueño</a>
            </div>
        </div>
    </li>

    {{-- Mascotas --}}
    <li class="nav-item {{ request()->routeIs('mascotas.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMascotas"
            aria-expanded="false" aria-controls="collapseMascotas">
            <i class="fas fa-fw fa-paw"></i>
            <span>Mascotas</span>
        </a>
        <div id="collapseMascotas" class="collapse {{ request()->routeIs('mascotas.*') ? 'show' : '' }}"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestión de Mascotas:</h6>
                <a class="collapse-item {{ request()->routeIs('mascotas.index') ? 'active' : '' }}" href="{{ route('mascotas.index') }}">Listar Mascotas</a>
                <a class="collapse-item {{ request()->routeIs('mascotas.create') ? 'active' : '' }}" href="{{ route('mascotas.create') }}">Nueva Mascota</a>
            </div>
        </div>
    </li>

    {{-- ── Administración ──────────────────────────────────────── --}}
    <div class="sidebar-heading">Administración</div>

    {{-- Usuarios --}}
    <li class="nav-item {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuarios"
            aria-expanded="{{ request()->routeIs('admin.usuarios.*') ? 'true' : 'false' }}"
            aria-controls="collapseUsuarios">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Usuarios</span>
        </a>
        <div id="collapseUsuarios"
             class="collapse {{ request()->routeIs('admin.usuarios.*') ? 'show' : '' }}"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestión de Usuarios:</h6>
                <a class="collapse-item {{ request()->routeIs('admin.usuarios.index') ? 'active' : '' }}"
                   href="{{ route('admin.usuarios.index') }}">
                   <i class="fas fa-list mr-1 text-muted"></i> Listar Usuarios
                </a>
                <a class="collapse-item {{ request()->routeIs('admin.usuarios.create') ? 'active' : '' }}"
                   href="{{ route('admin.usuarios.create') }}">
                   <i class="fas fa-user-plus mr-1 text-muted"></i> Nuevo Usuario
                </a>
            </div>
        </div>
    </li>

    {{-- Configuración del Sistema --}}
    <li class="nav-item {{ request()->routeIs('admin.configuracion') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.configuracion') }}">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Configuración</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
{{-- FIN SIDEBAR ADMINISTRADOR --}}
