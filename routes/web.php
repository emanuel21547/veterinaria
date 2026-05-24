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

        // ── Antecedentes (Alergias) ──
        Route::get('mascota/{mascota}/alergias',    [VeterinarioController::class, 'antAlergias'])   ->name('mascota.alergias');
        Route::post('mascota/{mascota}/alergias',   [VeterinarioController::class, 'storeAlergia'])  ->name('mascota.alergias.store');
        Route::delete('alergias/{alergia}',         [VeterinarioController::class, 'destroyAlergia'])->name('alergias.destroy');

        // ── Antecedentes (Lesiones) ──
        Route::get('mascota/{mascota}/lesiones',    [VeterinarioController::class, 'antLesiones'])   ->name('mascota.lesiones');
        Route::post('mascota/{mascota}/lesiones',   [VeterinarioController::class, 'storeLesion'])   ->name('mascota.lesiones.store');
        Route::delete('lesiones/{lesion}',          [VeterinarioController::class, 'destroyLesion']) ->name('lesiones.destroy');

        // ── Antecedentes (Patológicas) ──
        Route::get('mascota/{mascota}/patologicas', [VeterinarioController::class, 'antPatologicas'])->name('mascota.patologicas');
        Route::post('mascota/{mascota}/patologicas',[VeterinarioController::class, 'storePatologica'])->name('mascota.patologicas.store');
        Route::delete('patologicas/{patologica}',   [VeterinarioController::class, 'destroyPatologica'])->name('patologicas.destroy');

        // ── Historial Alimentación ──
        Route::get('mascota/{mascota}/alimentacion',[VeterinarioController::class, 'histAlimentacion'])->name('mascota.alimentacion');
        Route::post('mascota/{mascota}/alimentacion',[VeterinarioController::class, 'storeAlimentacion'])->name('mascota.alimentacion.store');
        Route::delete('alimentacion/{alimentacion}',[VeterinarioController::class, 'destroyAlimentacion'])->name('alimentacion.destroy');
    });
});
