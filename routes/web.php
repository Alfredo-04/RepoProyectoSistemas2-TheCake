<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MenuController;


Route::get('/registro-cliente', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('/registro-cliente', [UsuarioController::class, 'store'])->name('usuarios.store');

/* Route::get('/', function () {
    return "Página principal - <a href='/login-signup'>Ir al formulario de cliente</a>";
}); */


// Página principal
Route::get('/', function () {
    return view('home.index');
})->name('home');

//menu
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

// Sucursales
Route::get('/sucursales', function () {
    return view('branches.index');
})->name('branches');

// Contacto
Route::get('/contacto', function () {
    return view('contact.index');
})->name('contact');

Route::post('/contacto', [ContactController::class, 'submit'])->name('contact.submit');



// NO TOQUEN NADA DEL LOGIN POR FAVOR X'''D ME HA COSTADO MUCHO HACERLO

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
