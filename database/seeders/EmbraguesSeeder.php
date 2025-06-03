<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class EmbraguesSeeder extends Seeder
{
    public function run(): void
    {
        $embraguesCategory = Category::where('name', 'Embragues')->first();

        // Kit de embrague LUK para vehículos compactos
        $embragueCompacto = Part::create([
            'name' => 'Kit de Embrague LUK 01-001',
            'code' => 'EMB-LUK-01001',
            'description' => 'Kit de embrague LUK para vehículos compactos. Diámetro: 200mm. Tipo: Monomasa. Incluye: Disco, Plato y Rodamiento. Garantía de 2 años.',
            'price' => 199.99,
            'stock' => 15,
            'image_url' => '/images/parts/kit-embrague-LUK.jpg',
            'category_id' => $embraguesCategory->id,
            'is_active' => true
        ]);

        // Kit de embrague LUK para vehículos medianos
        $embragueMediano = Part::create([
            'name' => 'Kit de Embrague LUK 01-002',
            'code' => 'EMB-LUK-01002',
            'description' => 'Kit de embrague LUK para vehículos medianos. Diámetro: 228mm. Tipo: Monomasa. Incluye: Disco, Plato y Rodamiento. Garantía de 2 años.',
            'price' => 249.99,
            'stock' => 12,
            'image_url' => '/images/parts/kit-embrague-LUK.jpg',
            'category_id' => $embraguesCategory->id,
            'is_active' => true
        ]);

        // Kit de embrague LUK para vehículos premium
        $embraguePremium = Part::create([
            'name' => 'Kit de Embrague LUK 01-003',
            'code' => 'EMB-LUK-01003',
            'description' => 'Kit de embrague LUK para vehículos premium. Diámetro: 240mm. Tipo: Bimasa. Incluye: Disco, Plato y Rodamiento. Garantía de 2 años.',
            'price' => 299.99,
            'stock' => 10,
            'image_url' => '/images/parts/kit-embrague-LUK.jpg',
            'category_id' => $embraguesCategory->id,
            'is_active' => true
        ]);

        // Relacionar embragues con modelos específicos
        $modelosCompactos = CarModel::whereIn('name', ['Golf', 'A3', 'León'])->get();
        $embragueCompacto->models()->attach($modelosCompactos->pluck('id'));

        $modelosMedianos = CarModel::whereIn('name', ['Passat', 'A4', 'Toledo'])->get();
        $embragueMediano->models()->attach($modelosMedianos->pluck('id'));

        $modelosPremium = CarModel::whereIn('name', ['A6', 'Serie 5', 'Clase E'])->get();
        $embraguePremium->models()->attach($modelosPremium->pluck('id'));
    }
}
