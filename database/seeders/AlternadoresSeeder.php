<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class AlternadoresSeeder extends Seeder
{
    public function run(): void
    {
        $alternadoresCategory = Category::where('name', 'Alternadores')->first();
        $modelos = CarModel::all();

        // Alternador BOSCH
        $alternadorBosch = Part::create([
            'name' => 'Alternador BOSCH AL096X',
            'code' => 'ALT-BOSCH-AL096X',
            'description' => 'Alternador BOSCH AL096X de 150A. Compatible con vehículos de alta gama. Incluye regulador de voltaje integrado y sistema de enfriamiento mejorado. Ideal para vehículos con alto consumo eléctrico. Garantía de 2 años.',
            'price' => 299.99,
            'stock' => 10,
            'image_url' => '/images/parts/alterador-bosch.jpg',
            'category_id' => $alternadoresCategory->id,
            'is_active' => true
        ]);

        // Alternador Valeo
        $alternadorValeo = Part::create([
            'name' => 'Alternador Valeo ALX-120',
            'code' => 'ALT-VALEO-ALX120',
            'description' => 'Alternador Valeo ALX-120 de 120A. Equipado con sistema de refrigeración líquida y regulador de voltaje inteligente. Compatible con vehículos de gama media y alta. Incluye sistema de diagnóstico integrado. Garantía de 24 meses.',
            'price' => 279.99,
            'stock' => 15,
            'image_url' => '/images/parts/alternador_valeo.jpg',
            'category_id' => $alternadoresCategory->id,
            'is_active' => true
        ]);

        // Relacionar los alternadores con los modelos
        $alternadorBosch->models()->attach($modelos->pluck('id'));
        $alternadorValeo->models()->attach($modelos->pluck('id'));
    }
}
