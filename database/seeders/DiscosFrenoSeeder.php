<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class DiscosFrenoSeeder extends Seeder
{
    public function run(): void
    {
        $discosCategory = Category::where('name', 'Discos de Freno')->first();

        // Disco de freno Bosch para vehículos compactos
        $discoBoschCompacto = Part::create([
            'name' => 'Disco de Freno Bosch 0986498080',
            'code' => 'DIS-BOSCH-0986498080',
            'description' => 'Disco de freno Bosch para vehículos compactos. Diámetro: 288mm. Ventilado. Material: Fundición gris. Incluye tornillos de montaje. Garantía de 2 años.',
            'price' => 49.99,
            'stock' => 30,
            'image_url' => '/images/parts/disco-de-freno-bosch.jpg',
            'category_id' => $discosCategory->id,
            'is_active' => true
        ]);

        // Disco de freno Bosch para vehículos medianos
        $discoBoschMediano = Part::create([
            'name' => 'Disco de Freno Bosch 0986498081',
            'code' => 'DIS-BOSCH-0986498081',
            'description' => 'Disco de freno Bosch para vehículos medianos. Diámetro: 312mm. Ventilado. Material: Fundición gris. Incluye tornillos de montaje. Garantía de 2 años.',
            'price' => 59.99,
            'stock' => 25,
            'image_url' => '/images/parts/disco-de-freno-bosch2.jpg',
            'category_id' => $discosCategory->id,
            'is_active' => true
        ]);

        // Disco de freno Bosch para vehículos premium
        $discoBoschPremium = Part::create([
            'name' => 'Disco de Freno Bosch 0986498082',
            'code' => 'DIS-BOSCH-0986498082',
            'description' => 'Disco de freno Bosch para vehículos premium. Diámetro: 340mm. Ventilado perforado. Material: Fundición gris. Incluye tornillos de montaje. Garantía de 2 años.',
            'price' => 69.99,
            'stock' => 20,
            'image_url' => '/images/parts/disco-de-freno-bosch3.jpg',
            'category_id' => $discosCategory->id,
            'is_active' => true
        ]);

        // Relacionar discos con modelos específicos
        $modelosCompactos = CarModel::whereIn('name', ['Golf', 'A3', 'León'])->get();
        $discoBoschCompacto->models()->attach($modelosCompactos->pluck('id'));

        $modelosMedianos = CarModel::whereIn('name', ['Passat', 'A4', 'Toledo'])->get();
        $discoBoschMediano->models()->attach($modelosMedianos->pluck('id'));

        $modelosPremium = CarModel::whereIn('name', ['A6', 'Serie 5', 'Clase E'])->get();
        $discoBoschPremium->models()->attach($modelosPremium->pluck('id'));
    }
}
