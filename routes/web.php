<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DuenoController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VeterinarioController;
use Illuminate\Support\Facades\Route;

// ── Rutas públicas (solo para invitados) ──────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/',        [AuthController::class, 'index'])->name('login');
    Route::post('/logear', [AuthController::class, 'logear'])->name('logear');
});

// ── Rutas protegidas (requieren autenticación) ────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard (redirige por rol dentro del controlador)
    Route::get('/home',   [AuthController::class, 'home'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // ════════════════════════════════════════════════════════════════
    // RUTAS COMPARTIDAS (admin y veterinario)
    // ════════════════════════════════════════════════════════════════

    // Dueños
    Route::resource('duenos', DuenoController::class)->except(['show']);

    // Mascotas
    Route::resource('mascotas', MascotaController::class)->except(['show']);

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

        // Expediente — pantalla principal del veterinario
        Route::get('expediente',    [VeterinarioController::class, 'expediente'])->name('expediente');

        // AJAX: búsqueda en tiempo real de mascotas
        Route::get('buscar',        [VeterinarioController::class, 'buscar'])->name('buscar');

        // Historial de consultas de una mascota
        Route::get('mascota/{mascota}/consultas', [VeterinarioController::class, 'consultas'])
             ->name('mascota.consultas');

        // Nueva consulta
        Route::get('consulta/nueva/{mascota}',    [VeterinarioController::class, 'crearConsulta'])
             ->name('consulta.crear');
        Route::post('consulta',                   [VeterinarioController::class, 'guardarConsulta'])
             ->name('consulta.guardar');

        // Detalle / edición de consulta
        Route::get('consulta/{consulta}/editar',  [VeterinarioController::class, 'editarConsulta'])
             ->name('consulta.editar');
        Route::put('consulta/{consulta}',         [VeterinarioController::class, 'actualizarConsulta'])
             ->name('consulta.actualizar');

        // Secciones individuales (vistas del menú lateral del vet)
        Route::get('diagnostico',              [VeterinarioController::class, 'diagnostico'])    ->name('diagnostico');
        Route::get('tratamiento',              [VeterinarioController::class, 'tratamiento'])    ->name('tratamiento');
        Route::get('antecedentes/alergias',    [VeterinarioController::class, 'antAlergias'])   ->name('ant.alergias');
        Route::get('antecedentes/lesiones',    [VeterinarioController::class, 'antLesiones'])   ->name('ant.lesiones');
        Route::get('antecedentes/patologicas', [VeterinarioController::class, 'antPatologicas'])->name('ant.patologicas');
        Route::get('historial/alimentacion',   [VeterinarioController::class, 'histAlimentacion'])->name('hist.alimentacion');
    });
});
