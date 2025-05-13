<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Producto;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            'Porciones' => [
                ['nombre' => 'Pizza de Jamón', 'precio' => 12.00, 'descripcion' => 'Porción con jamón y queso.'],
                ['nombre' => 'Pizza Vegetariana', 'precio' => 13.00, 'descripcion' => 'Con vegetales frescos.']
            ],
            'Jugos' => [
                ['nombre' => 'Jugo de Naranja', 'precio' => 8.00, 'descripcion' => 'Natural y refrescante.'],
                ['nombre' => 'Jugo de Papaya', 'precio' => 7.50, 'descripcion' => 'Dulce y nutritivo.']
            ],
            'Cafés' => [
                ['nombre' => 'Café Expreso', 'precio' => 6.00, 'descripcion' => 'Fuerte y aromático.'],
                ['nombre' => 'Café Latte', 'precio' => 7.50, 'descripcion' => 'Con leche espumosa.']
            ]
        ];

        foreach ($categorias as $nombre => $productos) {
            $categoria = Categoria::create(['nombre' => $nombre]);
            foreach ($productos as $prod) {
                $categoria->productos()->create($prod);
            }
        }
    }
}