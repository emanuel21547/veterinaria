<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Acceso al Sistema Veterinaria">
    <meta name="author" content="Veterinaria">

    <title>@yield('titulo_pagina', 'Iniciar Sesión') | Veterinaria</title>

    {{-- FontAwesome --}}
    <link href="{{ asset('startbootstrap/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    {{-- SB Admin 2 CSS --}}
    <link href="{{ asset('startbootstrap/css/sb-admin-2.min.css') }}" rel="stylesheet">

    {{-- Estilos adicionales por página --}}
    @stack('styles')
</head>

<body class="bg-gradient-primary">

    {{-- ====================================================
         CONTENIDO DE LA PÁGINA DE LOGIN
         ==================================================== --}}
    @yield('contenido')
    {{-- FIN CONTENIDO --}}

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
