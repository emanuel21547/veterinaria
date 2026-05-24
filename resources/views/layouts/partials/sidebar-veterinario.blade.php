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

    {{-- Expediente — Pantalla principal ─────────────────────────────── --}}
    <li class="nav-item {{ request()->routeIs('home') || request()->routeIs('veterinario.expediente') || request()->routeIs('veterinario.mascota.*') || request()->routeIs('veterinario.consulta.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-folder-open"></i>
            <span>Expedientes</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    @if(isset($mascota))
        <hr class="sidebar-divider">

        {{-- ── Tablero Clínico ──────────────────────────────────────── --}}
        <div class="sidebar-heading">
            Paciente: {{ $mascota->nombre }}
        </div>

        {{-- Consultas --}}
        <li class="nav-item {{ request()->routeIs('veterinario.mascota.consultas') || request()->routeIs('veterinario.consulta.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('veterinario.mascota.consultas', $mascota) }}">
                <i class="fas fa-fw fa-stethoscope"></i>
                <span>Historial de Consultas</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        {{-- ── Antecedentes ─────────────────────────────────────────── --}}
        <div class="sidebar-heading">Antecedentes</div>

        <li class="nav-item {{ request()->routeIs('veterinario.mascota.alergias') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('veterinario.mascota.alergias', $mascota) }}">
                <i class="fas fa-fw fa-allergies"></i>
                <span>Alergias</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('veterinario.mascota.lesiones') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('veterinario.mascota.lesiones', $mascota) }}">
                <i class="fas fa-fw fa-band-aid"></i>
                <span>Lesiones</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('veterinario.mascota.patologicas') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('veterinario.mascota.patologicas', $mascota) }}">
                <i class="fas fa-fw fa-heartbeat"></i>
                <span>Patológicas</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        {{-- ── Historial ────────────────────────────────────────────── --}}
        <div class="sidebar-heading">Historial</div>

        <li class="nav-item {{ request()->routeIs('veterinario.mascota.alimentacion') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('veterinario.mascota.alimentacion', $mascota) }}">
                <i class="fas fa-fw fa-bone"></i>
                <span>Alimentación</span>
            </a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">
    @endif

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
{{-- FIN SIDEBAR VETERINARIO --}}
