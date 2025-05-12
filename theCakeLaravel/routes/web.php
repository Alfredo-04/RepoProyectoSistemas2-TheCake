<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/registro-cliente', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('/registro-cliente', [UsuarioController::class, 'store'])->name('usuarios.store');

Route::get('/', function () {
    return "Página principal - <a href='/login-signup'>Ir al formulario de cliente</a>";
});

// 👇 Solo usuarios no autenticados pueden acceder a login/signup
Route::middleware('guest')->group(function () {
    Route::get('/login-signup', [LoginController::class, 'showLoginForm'])->name('login.show');
    Route::post('/login-signup', [LoginController::class, 'login'])->name('login');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
   
// Ruta protegida
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
