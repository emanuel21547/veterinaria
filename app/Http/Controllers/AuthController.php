<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function index()
    {
        return view('modules.auth.login');
    }

    /**
     * Procesa el intento de login y redirige según el rol.
     */
    public function logear(Request $request)
    {
        $credenciales = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();
            return to_route('home');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput($request->only('email'));
    }

    /**
     * Muestra el dashboard correspondiente según el rol del usuario.
     * Admin  → vista de administrador
     * Vet    → vista de veterinario
     */
    public function home()
    {
        $user = Auth::user();

        if ($user->esAdmin()) {
            return view('modules.admin.dashboard');
        }

        // El veterinario ve directamente el buscador de expedientes
        return view('modules.veterinario.expediente.index');
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return to_route('login');
    }
}
