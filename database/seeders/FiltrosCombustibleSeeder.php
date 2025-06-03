<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class FiltrosCombustibleSeeder extends Seeder
{
    public function run(): void
    {
        $filtrosCombustibleCategory = Category::where('name', 'Filtros de Combustible')->first();

        // Filtro de combustible Mann WK para vehículos compactos
        $filtroCombustibleCompacto = Part::create([
            'name' => 'Filtro de Combustible Mann WK 69/1',
            'code' => 'FIL-COM-MANN-WK691',
            'description' => 'Filtro de combustible Mann WK para vehículos compactos. Diámetro: 69mm. Altura: 100mm. Material: Papel sintético. Garantía de 1 año.',
            'price' => 19.99,
            'stock' => 60,
            'image_url' => '/images/parts/filtro-combustible-mann.jpg',
            'category_id' => $filtrosCombustibleCategory->id,
            'is_active' => true
        ]);

        // Filtro de combustible Mann WK para vehículos medianos
        $filtroCombustibleMediano = Part::create([
            'name' => 'Filtro de Combustible Mann WK 69/2',
            'code' => 'FIL-COM-MANN-WK692',
            'description' => 'Filtro de combustible Mann WK para vehículos medianos. Diámetro: 69mm. Altura: 120mm. Material: Papel sintético. Garantía de 1 año.',
            'price' => 22.99,
            'stock' => 50,
            'image_url' => '/images/parts/filtro-combustible-mann2.jpg',
            'category_id' => $filtrosCombustibleCategory->id,
            'is_active' => true
        ]);

        // Filtro de combustible Mann WK para vehículos premium
        $filtroCombustiblePremium = Part::create([
            'name' => 'Filtro de Combustible Mann WK 69/3',
            'code' => 'FIL-COM-MANN-WK693',
            'description' => 'Filtro de combustible Mann WK para vehículos premium. Diámetro: 69mm. Altura: 140mm. Material: Papel sintético. Garantía de 1 año.',
            'price' => 25.99,
            'stock' => 40,
            'image_url' => '/images/parts/filtro-combustible-mann3.jpg',
            'category_id' => $filtrosCombustibleCategory->id,
            'is_active' => true
        ]);

        // Relacionar filtros con modelos específicos
        $modelosCompactos = CarModel::whereIn('name', ['Golf', 'A3', 'León'])->get();
        $filtroCombustibleCompacto->models()->attach($modelosCompactos->pluck('id'));

        $modelosMedianos = CarModel::whereIn('name', ['Passat', 'A4', 'Toledo'])->get();
        $filtroCombustibleMediano->models()->attach($modelosMedianos->pluck('id'));

        $modelosPremium = CarModel::whereIn('name', ['A6', 'Serie 5', 'Clase E'])->get();
        $filtroCombustiblePremium->models()->attach($modelosPremium->pluck('id'));
    }
}
