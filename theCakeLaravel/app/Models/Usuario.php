<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id_usuario'; // Clave primaria

    public $timestamps = false; // Desactivar los timestamps si no se utilizan

    protected $fillable = [
        'nombre',
        'apePat',
        'apeMat',
        'correo',
        'contraseña',
        'rol_id'
    ];

    protected $hidden = [
        'contraseña', // Ocultar la contraseña al serializar
    ];

    public function getAuthPassword()
    {
        return $this->contraseña; // Aquí le dices a Laravel qué campo usar
    }

    // Relación con la tabla roles
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id', 'id_rol');
    }



    // Relación con la tabla clientes
    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'id_usuario', 'id_usuario');
    }
}