<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventarioProducto extends Model
{
    protected $table = 'inventario_productos';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = ['id_producto', 'cantidad_disponible'];
}
