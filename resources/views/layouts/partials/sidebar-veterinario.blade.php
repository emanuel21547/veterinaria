{{-- ============================================================
     SIDEBAR VETERINARIO
     ============================================================ --}}
<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Logo --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-stethoscope"></i>
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

    {{-- ── Consultas ────────────────────────────────────────────── --}}
    <div class="sidebar-heading">Consulta</div>

    {{-- Diagnóstico --}}
    <li class="nav-item {{ request()->routeIs('veterinario.diagnostico') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('veterinario.diagnostico') }}">
            <i class="fas fa-fw fa-microscope"></i>
            <span>Diagnóstico</span>
        </a>
    </li>

    {{-- Tratamiento --}}
    <li class="nav-item {{ request()->routeIs('veterinario.tratamiento') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('veterinario.tratamiento') }}">
            <i class="fas fa-fw fa-pills"></i>
            <span>Tratamiento</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    {{-- ── Antecedentes ─────────────────────────────────────────── --}}
    <div class="sidebar-heading">Antecedentes</div>

    {{-- Antecedentes: Alergias --}}
    <li class="nav-item {{ request()->routeIs('veterinario.ant.alergias') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('veterinario.ant.alergias') }}">
            <i class="fas fa-fw fa-allergies"></i>
            <span>Alergias</span>
        </a>
    </li>

    {{-- Antecedentes: Lesiones --}}
    <li class="nav-item {{ request()->routeIs('veterinario.ant.lesiones') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('veterinario.ant.lesiones') }}">
            <i class="fas fa-fw fa-band-aid"></i>
            <span>Lesiones</span>
        </a>
    </li>

    {{-- Antecedentes: Patológicas --}}
    <li class="nav-item {{ request()->routeIs('veterinario.ant.patologicas') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('veterinario.ant.patologicas') }}">
            <i class="fas fa-fw fa-heartbeat"></i>
            <span>Patológicas</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    {{-- ── Historial ────────────────────────────────────────────── --}}
    <div class="sidebar-heading">Historial</div>

    {{-- Historial: Alimentación --}}
    <li class="nav-item {{ request()->routeIs('veterinario.hist.alimentacion') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('veterinario.hist.alimentacion') }}">
            <i class="fas fa-fw fa-bone"></i>
            <span>Alimentación</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
{{-- FIN SIDEBAR VETERINARIO --}}
