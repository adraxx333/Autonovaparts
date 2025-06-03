<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class TermostatosSeeder extends Seeder
{
    public function run(): void
    {
        $termostatosCategory = Category::where('name', 'Termostatos')->first();

        // Termostato Behr Hella para vehículos compactos
        $termostatoBehrCompacto = Part::create([
            'name' => 'Termostato Behr Hella Service 7TC 1',
            'code' => 'TER-BEHR-7TC1',
            'description' => 'Termostato Behr Hella Service para vehículos compactos. Temperatura de apertura: 87°C. Diámetro: 52mm. Material: Latón. Incluye junta. Garantía de 2 años.',
            'price' => 22.99,
            'stock' => 50,
            'image_url' => '/images/parts/termostat-Behr-Hella.jpg',
            'category_id' => $termostatosCategory->id,
            'is_active' => true
        ]);

        // Termostato Behr Hella para vehículos medianos
        $termostatoBehrMediano = Part::create([
            'name' => 'Termostato Behr Hella Service 7TC 2',
            'code' => 'TER-BEHR-7TC2',
            'description' => 'Termostato Behr Hella Service para vehículos medianos. Temperatura de apertura: 90°C. Diámetro: 58mm. Material: Latón. Incluye junta. Garantía de 2 años.',
            'price' => 24.99,
            'stock' => 40,
            'image_url' => '/images/parts/termostat-Behr-Hella.jpg',
            'category_id' => $termostatosCategory->id,
            'is_active' => true
        ]);

        // Termostato Behr Hella para vehículos premium
        $termostatoBehrPremium = Part::create([
            'name' => 'Termostato Behr Hella Service 7TC 3',
            'code' => 'TER-BEHR-7TC3',
            'description' => 'Termostato Behr Hella Service para vehículos premium. Temperatura de apertura: 92°C. Diámetro: 64mm. Material: Latón. Incluye junta. Garantía de 2 años.',
            'price' => 26.99,
            'stock' => 30,
            'image_url' => '/images/parts/termostat-Behr-Hella.jpg',
            'category_id' => $termostatosCategory->id,
            'is_active' => true
        ]);

        // Termostato Mahle para vehículos compactos
        $termostatoMahleCompacto = Part::create([
            'name' => 'Termostato Mahle TI 32 88D',
            'code' => 'TER-MAHLE-TI3288D',
            'description' => 'Termostato Mahle para vehículos compactos. Temperatura de apertura: 88°C. Diámetro: 54mm. Material: Latón. Incluye junta. Garantía de 2 años.',
            'price' => 21.99,
            'stock' => 45,
            'image_url' => '/images/parts/termostat-mahle.jpg',
            'category_id' => $termostatosCategory->id,
            'is_active' => true
        ]);

        // Termostato Mahle para vehículos medianos
        $termostatoMahleMediano = Part::create([
            'name' => 'Termostato Mahle TI 32 90D',
            'code' => 'TER-MAHLE-TI3290D',
            'description' => 'Termostato Mahle para vehículos medianos. Temperatura de apertura: 90°C. Diámetro: 60mm. Material: Latón. Incluye junta. Garantía de 2 años.',
            'price' => 23.99,
            'stock' => 35,
            'image_url' => '/images/parts/termostat-mahle.jpg',
            'category_id' => $termostatosCategory->id,
            'is_active' => true
        ]);

        // Termostato Mahle para vehículos premium
        $termostatoMahlePremium = Part::create([
            'name' => 'Termostato Mahle TI 32 92D',
            'code' => 'TER-MAHLE-TI3292D',
            'description' => 'Termostato Mahle para vehículos premium. Temperatura de apertura: 92°C. Diámetro: 66mm. Material: Latón. Incluye junta. Garantía de 2 años.',
            'price' => 25.99,
            'stock' => 25,
            'image_url' => '/images/parts/termostat-mahle.jpg',
            'category_id' => $termostatosCategory->id,
            'is_active' => true
        ]);

        // Relacionar termostatos con modelos específicos
        $modelosCompactos = CarModel::whereIn('name', ['Golf', 'A3', 'León'])->get();
        $termostatoBehrCompacto->models()->attach($modelosCompactos->pluck('id'));
        $termostatoMahleCompacto->models()->attach($modelosCompactos->pluck('id'));

        $modelosMedianos = CarModel::whereIn('name', ['Passat', 'A4', 'Toledo'])->get();
        $termostatoBehrMediano->models()->attach($modelosMedianos->pluck('id'));
        $termostatoMahleMediano->models()->attach($modelosMedianos->pluck('id'));

        $modelosPremium = CarModel::whereIn('name', ['A6', 'Serie 5', 'Clase E'])->get();
        $termostatoBehrPremium->models()->attach($modelosPremium->pluck('id'));
        $termostatoMahlePremium->models()->attach($modelosPremium->pluck('id'));
    }
}
