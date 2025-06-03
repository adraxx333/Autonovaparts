<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class FiltrosAceiteSeeder extends Seeder
{
    public function run(): void
    {
        $filtrosAceiteCategory = Category::where('name', 'Filtros de Aceite')->first();

        // Filtro de aceite Mann para vehículos compactos
        $filtroAceiteCompacto = Part::create([
            'name' => 'Filtro de Aceite Mann HU 718/6 X',
            'code' => 'FIL-ACE-MANN-7186X',
            'description' => 'Filtro de aceite Mann para vehículos compactos. Rosca: M22x1.5. Diámetro: 76mm. Altura: 75mm. Material: Papel sintético. Garantía de 1 año.',
            'price' => 12.99,
            'stock' => 100,
            'image_url' => '/images/parts/filtro-aceite-mann.jpg',
            'category_id' => $filtrosAceiteCategory->id,
            'is_active' => true
        ]);

        // Filtro de aceite Mann para vehículos medianos
        $filtroAceiteMediano = Part::create([
            'name' => 'Filtro de Aceite Mann HU 719/6 X',
            'code' => 'FIL-ACE-MANN-7196X',
            'description' => 'Filtro de aceite Mann para vehículos medianos. Rosca: M24x1.5. Diámetro: 80mm. Altura: 80mm. Material: Papel sintético. Garantía de 1 año.',
            'price' => 14.99,
            'stock' => 80,
            'image_url' => '/images/parts/filtro-aceite-mann2.jpg',
            'category_id' => $filtrosAceiteCategory->id,
            'is_active' => true
        ]);

        // Filtro de aceite Mann para vehículos premium
        $filtroAceitePremium = Part::create([
            'name' => 'Filtro de Aceite Mann HU 720/6 X',
            'code' => 'FIL-ACE-MANN-7206X',
            'description' => 'Filtro de aceite Mann para vehículos premium. Rosca: M26x1.5. Diámetro: 85mm. Altura: 85mm. Material: Papel sintético. Garantía de 1 año.',
            'price' => 16.99,
            'stock' => 60,
            'image_url' => '/images/parts/filtro-aceite-mann3.jpg',
            'category_id' => $filtrosAceiteCategory->id,
            'is_active' => true
        ]);

        // Relacionar filtros con modelos específicos
        $modelosCompactos = CarModel::whereIn('name', ['Golf', 'A3', 'León'])->get();
        $filtroAceiteCompacto->models()->attach($modelosCompactos->pluck('id'));

        $modelosMedianos = CarModel::whereIn('name', ['Passat', 'A4', 'Toledo'])->get();
        $filtroAceiteMediano->models()->attach($modelosMedianos->pluck('id'));

        $modelosPremium = CarModel::whereIn('name', ['A6', 'Serie 5', 'Clase E'])->get();
        $filtroAceitePremium->models()->attach($modelosPremium->pluck('id'));
    }
}
