{{-- ============================================================
     SIDEBAR - Sistema Veterinaria
     ============================================================ --}}
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Marca / Logo --}}
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

    {{-- Sección: Clínica --}}
    <div class="sidebar-heading">Clínica</div>

    {{-- Pacientes --}}
    <li class="nav-item {{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePacientes"
            aria-expanded="false" aria-controls="collapsePacientes">
            <i class="fas fa-fw fa-dog"></i>
            <span>Pacientes</span>
        </a>
        <div id="collapsePacientes" class="collapse {{ request()->routeIs('pacientes.*') ? 'show' : '' }}"
            aria-labelledby="headingPacientes" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestión de Pacientes:</h6>
                <a class="collapse-item {{ request()->routeIs('pacientes.index') ? 'active' : '' }}"
                    href="#">Listar Pacientes</a>
                <a class="collapse-item {{ request()->routeIs('pacientes.create') ? 'active' : '' }}"
                    href="#">Nuevo Paciente</a>
            </div>
        </div>
    </li>

    {{-- Propietarios --}}
    <li class="nav-item {{ request()->routeIs('propietarios.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePropietarios"
            aria-expanded="false" aria-controls="collapsePropietarios">
            <i class="fas fa-fw fa-users"></i>
            <span>Propietarios</span>
        </a>
        <div id="collapsePropietarios" class="collapse {{ request()->routeIs('propietarios.*') ? 'show' : '' }}"
            aria-labelledby="headingPropietarios" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestión de Propietarios:</h6>
                <a class="collapse-item {{ request()->routeIs('propietarios.index') ? 'active' : '' }}"
                    href="#">Listar Propietarios</a>
                <a class="collapse-item {{ request()->routeIs('propietarios.create') ? 'active' : '' }}"
                    href="#">Nuevo Propietario</a>
            </div>
        </div>
    </li>

    {{-- Citas --}}
    <li class="nav-item {{ request()->routeIs('citas.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCitas"
            aria-expanded="false" aria-controls="collapseCitas">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Citas</span>
        </a>
        <div id="collapseCitas" class="collapse {{ request()->routeIs('citas.*') ? 'show' : '' }}"
            aria-labelledby="headingCitas" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestión de Citas:</h6>
                <a class="collapse-item {{ request()->routeIs('citas.index') ? 'active' : '' }}"
                    href="#">Ver Citas</a>
                <a class="collapse-item {{ request()->routeIs('citas.create') ? 'active' : '' }}"
                    href="#">Nueva Cita</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    {{-- ── Sección: Administración ────────────────────────────────── --}}
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
             aria-labelledby="headingUsuarios"
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

    <hr class="sidebar-divider d-none d-md-block">

    {{-- Botón colapsar sidebar --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
{{-- ============================================================
     FIN SIDEBAR
     ============================================================ --}}
