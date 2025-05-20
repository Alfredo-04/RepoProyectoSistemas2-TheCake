<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductoController;
use App\Http\Middleware\CheckRole;



Route::get('/registro-cliente', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('/registro-cliente', [UsuarioController::class, 'store'])->name('usuarios.store');

// Página principal
Route::get('/', function () {
    return view('home.index');
})->name('home');

//menu
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/pedido', [PedidoController::class, 'index'])->middleware(CheckRole::class . ':1,2,3,5')->name('pedido');

Route::get('/stock', [StockController::class, 'index'])->middleware(CheckRole::class . ':1,4')->name('stock.index');
Route::post('/stock/agregar', [StockController::class, 'agregarStock'])->middleware(CheckRole::class . ':1,4')->name('stock.agregar');

// ✅ Rutas para productos
Route::get('/productos', [ProductoController::class, 'index'])->middleware(CheckRole::class . ':1,4')->name('productos.index');
Route::post('/productos', [ProductoController::class, 'store'])->middleware(CheckRole::class . ':1,4')->name('productos.store');
Route::post('/productos/update', [ProductoController::class, 'update'])->middleware(CheckRole::class . ':1,4')->name('productos.update');
Route::get('/productos/delete/{id}', [ProductoController::class, 'destroy'])->middleware(CheckRole::class . ':1,4')->name('productos.destroy');


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
})->middleware('auth')->middleware(CheckRole::class . ':1,2,3,4')->name('dashboard');

Route::get('/error-custom', function () {
    abort(999, 'Este código de error no existe');
});

/* 
Route::get('/pedido', function () {
    return view('pedido');
})->middleware(CheckRole::class . ':1,3,5')->name('pedido'); */  // Admin, Mesero, Cliente

Route::get('/gestion-usuarios', function () {
    return view('gestion-usuarios');
})->middleware(CheckRole::class . ':1')->name('gestion.usuarios'); // Solo Admin

Route::get('/historial-pedidos', function () {
    return view('historial-pedidos');
})->middleware(CheckRole::class . ':1,2,3')->name('historial.pedidos'); // Admin, Cajero, Mesero

Route::get('/gestion-productos', function () {
    return view('gestion-productos');
})->middleware(CheckRole::class . ':1,4')->name('gestion.productos'); // Admin, Cocinero

Route::get('/gestion-mesas', function () {
    return view('gestion-mesas');
})->middleware(CheckRole::class . ':1,3')->name('gestion.mesas'); // Admin, Mesero

Route::get('/gestionar-stock', function () {
    return view('gestionar-stock');
})->middleware(CheckRole::class . ':1,4')->name('gestionar.stock'); // Admin, Cocinero



