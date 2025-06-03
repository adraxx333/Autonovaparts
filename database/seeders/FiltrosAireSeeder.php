<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class FiltrosAireSeeder extends Seeder
{
    public function run(): void
    {
        $filtrosAireCategory = Category::where('name', 'Filtros de Aire')->first();

        // Filtro de aire Mann para vehículos compactos
        $filtroAireCompacto = Part::create([
            'name' => 'Filtro de Aire Mann C 25 011',
            'code' => 'FIL-AIR-MANN-C25011',
            'description' => 'Filtro de aire Mann para vehículos compactos. Dimensiones: 250x200x50mm. Material: Papel sintético. Garantía de 1 año.',
            'price' => 15.99,
            'stock' => 80,
            'image_url' => '/images/parts/filtro-aire-mann.jpg',
            'category_id' => $filtrosAireCategory->id,
            'is_active' => true
        ]);

        // Filtro de aire Mann para vehículos medianos
        $filtroAireMediano = Part::create([
            'name' => 'Filtro de Aire Mann C 30 011',
            'code' => 'FIL-AIR-MANN-C30011',
            'description' => 'Filtro de aire Mann para vehículos medianos. Dimensiones: 300x250x50mm. Material: Papel sintético. Garantía de 1 año.',
            'price' => 18.99,
            'stock' => 60,
            'image_url' => '/images/parts/filtro-aire-mann2.jpg',
            'category_id' => $filtrosAireCategory->id,
            'is_active' => true
        ]);

        // Filtro de aire Mann para vehículos premium
        $filtroAirePremium = Part::create([
            'name' => 'Filtro de Aire Mann C 35 011',
            'code' => 'FIL-AIR-MANN-C35011',
            'description' => 'Filtro de aire Mann para vehículos premium. Dimensiones: 350x300x50mm. Material: Papel sintético. Garantía de 1 año.',
            'price' => 21.99,
            'stock' => 40,
            'image_url' => '/images/parts/filtro-aire-mann2.jpg',
            'category_id' => $filtrosAireCategory->id,
            'is_active' => true
        ]);

        // Relacionar filtros con modelos específicos
        $modelosCompactos = CarModel::whereIn('name', ['Golf', 'A3', 'León'])->get();
        $filtroAireCompacto->models()->attach($modelosCompactos->pluck('id'));

        $modelosMedianos = CarModel::whereIn('name', ['Passat', 'A4', 'Toledo'])->get();
        $filtroAireMediano->models()->attach($modelosMedianos->pluck('id'));

        $modelosPremium = CarModel::whereIn('name', ['A6', 'Serie 5', 'Clase E'])->get();
        $filtroAirePremium->models()->attach($modelosPremium->pluck('id'));
    }
}
