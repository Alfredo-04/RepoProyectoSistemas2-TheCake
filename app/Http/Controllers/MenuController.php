<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Http\Requests\StoreMenuCategoriaRequest;
use App\Http\Requests\UpdateMenuCategoriaRequest;   

class MenuController extends Controller
{
    public function index()
    {
        $productos = DB::table('productos as p')
            ->join('categorias_productos as c', 'p.categoria_producto_id', '=', 'c.id_categoria')
            ->select('p.id_producto', 'p.nombre_producto', 'p.precio', 'p.descripcion', 'p.imagen', 'c.nombre_categoria')
            ->orderBy('c.nombre_categoria')
            ->orderBy('p.nombre_producto')
            ->get();

        $productosPorCategoria = [];

        foreach ($productos as $producto) {
            $productosPorCategoria[$producto->nombre_categoria][] = $producto;
        }

        return view('menu', ['productos' => $productos]);

    }
}