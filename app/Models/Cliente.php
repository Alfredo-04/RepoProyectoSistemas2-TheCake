<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id_cliente'; // Clave primaria
    
    public $timestamps = false; // Desactivar los timestamps si no se utilizan



    protected $fillable = [
        'id_usuario',
        'nombre',
        'apePat',
        'apeMat',
        'telefono',
        'correo'
    ];

    // Relación con usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}