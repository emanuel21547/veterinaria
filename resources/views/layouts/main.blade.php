<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de Gestión Veterinaria">
    <meta name="author" content="Veterinaria">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('titulo_pagina', 'Sistema Veterinaria') | Veterinaria</title>

    {{-- FontAwesome --}}
    <link href="{{ asset('startbootstrap/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    {{-- SB Admin 2 CSS --}}
    <link href="{{ asset('startbootstrap/css/sb-admin-2.min.css') }}" rel="stylesheet">

    {{-- Estilos adicionales por página --}}
    @stack('styles')
</head>

<body id="page-top">

    {{-- ====================================================
         WRAPPER PRINCIPAL
         ==================================================== --}}
    <div id="wrapper">

        {{-- SIDEBAR --}}
        @include('layouts.partials.sidebar')
        {{-- FIN SIDEBAR --}}

        {{-- CONTENT WRAPPER --}}
        <div id="content-wrapper" class="d-flex flex-column">

            {{-- CONTENIDO PRINCIPAL --}}
            <div id="content">

                {{-- TOPBAR --}}
                @include('layouts.partials.topbar')
                {{-- FIN TOPBAR --}}

                {{-- CONTENIDO DE PÁGINA --}}
                <div class="container-fluid">
                    @yield('contenido')
                </div>
                {{-- FIN CONTENIDO DE PÁGINA --}}

            </div>
            {{-- FIN CONTENIDO PRINCIPAL --}}

            {{-- FOOTER --}}
            @include('layouts.partials.footer')
            {{-- FIN FOOTER --}}

        </div>
        {{-- FIN CONTENT WRAPPER --}}

    </div>
    {{-- FIN WRAPPER PRINCIPAL --}}

    {{-- Botón scroll to top --}}
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    {{-- ====================================================
         MODAL DE LOGOUT
         ==================================================== --}}
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog"
        aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">
                        <i class="fas fa-sign-out-alt mr-2 text-danger"></i>
                        ¿Cerrar Sesión?
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Seleccione <strong>"Salir"</strong> si desea terminar su sesión actual.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <a class="btn btn-danger" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt mr-1"></i> Salir
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- FIN MODAL LOGOUT --}}

    {{-- ====================================================
         SCRIPTS
         ==================================================== --}}
    <script src="{{ asset('startbootstrap/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('startbootstrap/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('startbootstrap/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('startbootstrap/js/sb-admin-2.min.js') }}"></script>

    {{-- Scripts adicionales por página --}}
    @stack('scripts')

</body>

</html>
