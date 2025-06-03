<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id_rol'; // Clave primaria
    public $timestamps = false; // Desactivar los timestamps si no se utilizan
    protected $fillable = [
        'nombre_rol',
        'descripcion_rol'
    ];

    // Relación con usuarios
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'rol_id', 'id_rol');
    }

    
    
}