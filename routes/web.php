<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VeterinarioController;
use Illuminate\Support\Facades\Route;

// ── Rutas públicas (solo para invitados) ──────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/',       [AuthController::class, 'index'])->name('login');
    Route::post('/logear',[AuthController::class, 'logear'])->name('logear');
});

// ── Rutas protegidas (requieren autenticación) ────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard unificado (redirige por rol dentro del controlador)
    Route::get('/home',   [AuthController::class, 'home'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // ════════════════════════════════════════════════════════════════
    // RUTAS EXCLUSIVAS DE ADMINISTRADOR
    // ════════════════════════════════════════════════════════════════
    Route::middleware('es.admin')->prefix('admin')->name('admin.')->group(function () {

        // Usuarios CRUD
        Route::resource('usuarios', UsuarioController::class)->except(['show']);

        // Configuración del sistema
        Route::get('configuracion', function () {
            return view('modules.admin.configuracion');
        })->name('configuracion');
    });

    // ════════════════════════════════════════════════════════════════
    // RUTAS DEL VETERINARIO
    // ════════════════════════════════════════════════════════════════
    Route::prefix('veterinario')->name('veterinario.')->group(function () {

        // Consultas
        Route::get('diagnostico',           [VeterinarioController::class, 'diagnostico'])          ->name('diagnostico');
        Route::get('tratamiento',           [VeterinarioController::class, 'tratamiento'])           ->name('tratamiento');

        // Antecedentes
        Route::get('antecedentes/alergias',    [VeterinarioController::class, 'antAlergias'])       ->name('ant.alergias');
        Route::get('antecedentes/lesiones',    [VeterinarioController::class, 'antLesiones'])       ->name('ant.lesiones');
        Route::get('antecedentes/patologicas', [VeterinarioController::class, 'antPatologicas'])    ->name('ant.patologicas');

        // Historial
        Route::get('historial/alimentacion',   [VeterinarioController::class, 'histAlimentacion'])  ->name('hist.alimentacion');
    });
});
