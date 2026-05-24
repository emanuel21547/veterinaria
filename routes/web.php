<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// ── Rutas públicas (solo para invitados) ──────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/logear', [AuthController::class, 'logear'])->name('logear');
});

// ── Rutas protegidas (requieren autenticación) ────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/home', [AuthController::class, 'home'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // ── Administración: Usuarios ──
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('usuarios', UsuarioController::class)
             ->except(['show']);
    });
});
