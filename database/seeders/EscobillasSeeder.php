<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class EscobillasSeeder extends Seeder
{
    public function run(): void
    {
        $escobillasCategory = Category::where('name', 'Escobillas')->first();

        // Escobillas Bosch Aerotwin para vehículos compactos
        $escobillasBoschCompacto = Part::create([
            'name' => 'Escobillas Bosch Aerotwin A864S',
            'code' => 'ESC-BOSCH-A864S',
            'description' => 'Escobillas Bosch Aerotwin para vehículos compactos. Longitud: 600mm/400mm. Tecnología Twin Blade. Adaptador universal incluido. Garantía de 1 año.',
            'price' => 24.99,
            'stock' => 50,
            'image_url' => '/images/parts/escobillas-bosch.jpg',
            'category_id' => $escobillasCategory->id,
            'is_active' => true
        ]);

        // Escobillas Bosch Aerotwin para vehículos medianos
        $escobillasBoschMediano = Part::create([
            'name' => 'Escobillas Bosch Aerotwin A865S',
            'code' => 'ESC-BOSCH-A865S',
            'description' => 'Escobillas Bosch Aerotwin para vehículos medianos. Longitud: 650mm/450mm. Tecnología Twin Blade. Adaptador universal incluido. Garantía de 1 año.',
            'price' => 29.99,
            'stock' => 40,
            'image_url' => '/images/parts/escobillas-bosch.jpg',
            'category_id' => $escobillasCategory->id,
            'is_active' => true
        ]);

        // Escobillas Bosch Aerotwin para vehículos premium
        $escobillasBoschPremium = Part::create([
            'name' => 'Escobillas Bosch Aerotwin A866S',
            'code' => 'ESC-BOSCH-A866S',
            'description' => 'Escobillas Bosch Aerotwin para vehículos premium. Longitud: 700mm/500mm. Tecnología Twin Blade. Adaptador universal incluido. Garantía de 1 año.',
            'price' => 34.99,
            'stock' => 35,
            'image_url' => '/images/parts/escobillas-bosch.jpg',
            'category_id' => $escobillasCategory->id,
            'is_active' => true
        ]);

        // Relacionar escobillas con modelos específicos
        $modelosCompactos = CarModel::whereIn('name', ['Golf', 'A3', 'León'])->get();
        $escobillasBoschCompacto->models()->attach($modelosCompactos->pluck('id'));

        $modelosMedianos = CarModel::whereIn('name', ['Passat', 'A4', 'Toledo'])->get();
        $escobillasBoschMediano->models()->attach($modelosMedianos->pluck('id'));

        $modelosPremium = CarModel::whereIn('name', ['A6', 'Serie 5', 'Clase E'])->get();
        $escobillasBoschPremium->models()->attach($modelosPremium->pluck('id'));
    }
}
