@extends('layouts.auth')

@section('titulo_pagina', 'Iniciar Sesión')

@push('styles')
<style>
    /* ── Panel izquierdo con la imagen ── */
    .bg-login-image {
        background: url("{{ asset('img/login-bg.png') }}") center center / cover no-repeat;
        min-height: 500px;
        position: relative;
    }

    /* Overlay oscuro suave sobre la imagen */
    .bg-login-image::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(78, 115, 223, 0.55) 0%, rgba(28, 200, 138, 0.3) 100%);
        border-radius: 0;
    }

    /* Texto encima del overlay */
    .login-image-text {
        position: absolute;
        bottom: 40px;
        left: 0;
        right: 0;
        z-index: 2;
        text-align: center;
        color: #fff;
        padding: 0 24px;
    }

    .login-image-text h2 {
        font-size: 1.6rem;
        font-weight: 800;
        text-shadow: 0 2px 8px rgba(0,0,0,0.3);
        margin-bottom: 6px;
    }

    .login-image-text p {
        font-size: 0.9rem;
        opacity: 0.9;
        text-shadow: 0 1px 4px rgba(0,0,0,0.2);
    }

    /* ── Toggle contraseña ── */
    .password-wrapper {
        position: relative;
    }

    .password-wrapper .toggle-password {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #b7b9cc;
        background: none;
        border: none;
        padding: 0;
        line-height: 1;
        transition: color 0.2s ease;
        z-index: 5;
    }

    .password-wrapper .toggle-password:hover {
        color: #4e73df;
    }

    /* Ajuste para que el input no tape el ícono */
    .password-wrapper .form-control-user {
        padding-right: 42px;
    }

    /* ── Card y contenedor ── */
    .card.o-hidden {
        border-radius: 1rem;
        overflow: hidden;
    }

    /* ── Animación de entrada ── */
    .card.o-hidden {
        animation: fadeInUp 0.5s ease both;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('contenido')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">

                        {{-- ── Panel izquierdo: Imagen ── --}}
                        <div class="col-lg-6 d-none d-lg-block bg-login-image">
                            <div class="login-image-text">
                                <h2><i class="fas fa-paw mr-2"></i>Veterinaria</h2>
                                <p>Sistema profesional de gestión veterinaria</p>
                            </div>
                        </div>

                        {{-- ── Panel derecho: Formulario ── --}}
                        <div class="col-lg-6">
                            <div class="p-5">

                                {{-- Encabezado --}}
                                <div class="text-center mb-4">
                                    <div class="mb-3">
                                        <i class="fas fa-paw fa-3x text-primary"></i>
                                    </div>
                                    <h1 class="h4 text-gray-900 mb-1">¡Bienvenido de nuevo!</h1>
                                    <p class="text-muted small">Ingresa tus credenciales para acceder</p>
                                </div>

                                {{-- Alerta de error --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        <strong>Credenciales incorrectas.</strong> Verifica tu correo y contraseña.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                {{-- Formulario --}}
                                <form action="{{ route('logear') }}" method="POST" class="user">
                                    @csrf

                                    {{-- Email --}}
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-0">
                                                    <i class="fas fa-envelope text-primary"></i>
                                                </span>
                                            </div>
                                            <input
                                                type="email"
                                                class="form-control form-control-user @error('email') is-invalid @enderror"
                                                id="email"
                                                name="email"
                                                value="{{ old('email') }}"
                                                placeholder="Correo electrónico..."
                                                required
                                                autofocus>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Password con toggle ojo ── --}}
                                    <div class="form-group">
                                        <div class="password-wrapper">
                                            <input
                                                type="password"
                                                class="form-control form-control-user @error('password') is-invalid @enderror"
                                                id="password"
                                                name="password"
                                                placeholder="Contraseña"
                                                required>
                                            <button type="button"
                                                class="toggle-password"
                                                id="togglePassword"
                                                title="Mostrar / ocultar contraseña"
                                                aria-label="Mostrar contraseña">
                                                <i class="fas fa-eye" id="eyeIcon"></i>
                                            </button>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Botón Ingresar --}}
                                    <button type="submit" class="btn btn-primary btn-user btn-block mt-4">
                                        <i class="fas fa-sign-in-alt mr-2"></i>
                                        Iniciar Sesión
                                    </button>

                                </form>

                                <hr>

                                {{-- Pie --}}
                                <div class="text-center">
                                    <small class="text-muted">
                                        <i class="fas fa-shield-alt mr-1 text-success"></i>
                                        Acceso restringido al personal autorizado
                                    </small>
                                </div>

                            </div>
                        </div>
                        {{-- Fin panel derecho --}}

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle mostrar/ocultar contraseña
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input   = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const isHidden = input.type === 'password';

        input.type    = isHidden ? 'text' : 'password';
        eyeIcon.classList.toggle('fa-eye',      !isHidden);
        eyeIcon.classList.toggle('fa-eye-slash', isHidden);

        // Feedback visual en el ícono
        this.style.color = isHidden ? '#4e73df' : '#b7b9cc';
    });
</script>
@endpush
