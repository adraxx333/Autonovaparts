<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Alternadores',
            'description' => 'Alternadores para vehículos de diferentes marcas y modelos'
        ]);

        Category::create([
            'name' => 'Suspensión',
            'description' => 'Componentes de suspensión y amortiguación para vehículos'
        ]);

        Category::create([
            'name' => 'Baterías',
            'description' => 'Baterías para vehículos de diferentes marcas y modelos'
        ]);

        Category::create([
            'name' => 'Bobinas de Encendido',
            'description' => 'Bobinas de encendido para diferentes sistemas de ignición'
        ]);

        Category::create([
            'name' => 'Bombas de Agua',
            'description' => 'Bombas de agua para el sistema de refrigeración de vehículos'
        ]);

        Category::create([
            'name' => 'Bombas de Combustible',
            'description' => 'Bombas de combustible para sistemas de inyección'
        ]);

        Category::create([
            'name' => 'Bujías de Encendido',
            'description' => 'Bujías de encendido para diferentes tipos de motores'
        ]);

        Category::create([
            'name' => 'Centralitas',
            'description' => 'Unidades de control electrónico para diferentes sistemas del vehículo'
        ]);

        Category::create([
            'name' => 'Compresores de Aire Acondicionado',
            'description' => 'Compresores para sistemas de climatización de vehículos'
        ]);

        Category::create([
            'name' => 'Correas de Distribución',
            'description' => 'Correas de distribución y kits de distribución para diferentes motores'
        ]);

        Category::create([
            'name' => 'Discos de Freno',
            'description' => 'Discos de freno para diferentes sistemas de frenado'
        ]);

        Category::create([
            'name' => 'Embragues',
            'description' => 'Kits de embrague para diferentes vehículos'
        ]);

        Category::create([
            'name' => 'Escobillas',
            'description' => 'Escobillas limpiaparabrisas para diferentes vehículos'
        ]);

        Category::create([
            'name' => 'Filtros de Aceite',
            'description' => 'Filtros de aceite para diferentes motores'
        ]);

        Category::create([
            'name' => 'Filtros de Aire',
            'description' => 'Filtros de aire para diferentes motores'
        ]);

        Category::create([
            'name' => 'Filtros de Combustible',
            'description' => 'Filtros de combustible para diferentes sistemas de inyección'
        ]);

        Category::create([
            'name' => 'Filtros de Habitáculo',
            'description' => 'Filtros de habitáculo para diferentes vehículos'
        ]);

        Category::create([
            'name' => 'Termostatos',
            'description' => 'Termostatos para el sistema de refrigeración de vehículos'
        ]);

        Category::create([
            'name' => 'Motores de Arranque',
            'description' => 'Motores de arranque para diferentes vehículos'
        ]);
    }
}
