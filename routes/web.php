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
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\MesaController;
use App\Models\Empleado; 
use App\Http\Controllers\EstadisticasController;


/* Route::get('/usuarios', [UsuarioController::class, 'create'])->name('usuarios.create'); */
Route::post('/registro-cliente', [UsuarioController::class, 'store'])->name('usuarios.store');

Route::get('/usuarios', [UsuarioController::class, 'createEmpleado'])->name('gestion.usuarios')->middleware(CheckRole::class . ':1');
Route::post('/usuarios/empleados', [UsuarioController::class, 'storeEmpleado'])->name('usuarios.empleado.store');
Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');


Route::put('/clientes/{id}', [UsuarioController::class, 'updateCliente'])->name('clientes.update');
Route::delete('/clientes/{id}', [UsuarioController::class, 'destroyCliente'])->name('clientes.destroy');




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


Route::post('/procesar-pedido', [PedidoController::class, 'procesarPedido']);

//historial
Route::get('/historial', [HistorialController::class, 'index'])->name('historial')->middleware(CheckRole::class . ':1,2,4');
Route::post('/historial/update', [HistorialController::class, 'actualizarEstado'])->name('historial.update');
Route::get('/historial/pdf', [HistorialController::class, 'generarPDF'])->name('historial.pdf')->middleware(CheckRole::class . ':1,2,4');

//mesa
Route::resource('mesas', MesaController::class)->except(['show'])->middleware(CheckRole::class . ':1,2,3');
Route::get('/mesas-disponibles', [MesaController::class, 'mesasDisponibles']);
Route::post('/actualizar-estado-mesa', [MesaController::class, 'actualizarEstadoMesa']);



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

/* Route::get('/gestion-usuarios', function () {
    return view('gestion-usuarios');
})->middleware(CheckRole::class . ':1')->name('gestion.usuarios'); // Solo Admin */

/* Route::get('/historial-pedidos', function () {
    return view('historial-pedidos');
})->middleware(CheckRole::class . ':1,2,3')->name('historial.pedidos'); // Admin, Cajero, Mesero */

Route::get('/gestion-productos', function () {
    return view('gestion-productos');
})->middleware(CheckRole::class . ':1,4')->name('gestion.productos'); // Admin, Cocinero

/* Route::get('/gestion-mesas', function () {
    return view('gestion-mesas');
})->middleware(CheckRole::class . ':1,3')->name('gestion.mesas'); // Admin, Mesero */

Route::get('/gestionar-stock', function () {
    return view('gestionar-stock');
})->middleware(CheckRole::class . ':1,4')->name('gestionar.stock'); // Admin, Cocinero




    Route::get('/estadisticas', [EstadisticasController::class, 'index'])
        ->name('estadisticas')->middleware(CheckRole::class . ':1');





