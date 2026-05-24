{{-- ============================================================
     TOPBAR - Sistema Veterinaria
     ============================================================ --}}
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    {{-- Botón toggle sidebar (móvil) --}}
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    {{-- Indicador de paciente (visible en pantallas medianas+) --}}
    @if(Auth::user()->esVeterinario())
        <div class="d-none d-sm-inline-block ml-md-3 my-2 my-md-0 mw-100">
            @if(isset($mascota) && request()->routeIs('veterinario.*'))
                <span class="badge badge-success px-3 py-2" style="font-size: 0.9rem;">
                    <i class="fas fa-paw mr-2"></i> Paciente seleccionado: <strong>{{ $mascota->nombre }}</strong>
                </span>
            @else
                <span class="badge badge-secondary px-3 py-2" style="font-size: 0.9rem;">
                    <i class="fas fa-info-circle mr-2"></i> Ningún paciente seleccionado
                </span>
            @endif
        </div>
    @endif

    {{-- Íconos de la derecha --}}
    <ul class="navbar-nav ml-auto">



        <div class="topbar-divider d-none d-sm-block"></div>

        {{-- Menú de usuario --}}
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ Auth::user()->name ?? 'Usuario' }}
                </span>
                <img class="img-profile rounded-circle"
                    src="{{ asset('startbootstrap/img/undraw_profile.svg') }}" alt="Perfil">
            </a>
            {{-- Dropdown usuario --}}
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Mi Perfil
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Cerrar Sesión
                </a>
            </div>
        </li>

    </ul>
</nav>
{{-- ============================================================
     FIN TOPBAR
     ============================================================ --}}
