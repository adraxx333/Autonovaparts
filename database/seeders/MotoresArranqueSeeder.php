<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class MotoresArranqueSeeder extends Seeder
{
    public function run(): void
    {
        $motoresArranqueCategory = Category::where('name', 'Motores de Arranque')->first();

        // Motor de arranque Denso DSN12 para vehículos compactos
        $motorArranqueCompacto = Part::create([
            'name' => 'Motor de Arranque Denso DSN12',
            'code' => 'MAR-DENSO-DSN12',
            'description' => 'Motor de arranque Denso DSN12 para vehículos compactos. Potencia: 1.2kW. Voltaje: 12V. Dientes: 9. Incluye tornillos de montaje. Garantía de 2 años.',
            'price' => 149.99,
            'stock' => 20,
            'image_url' => '/images/parts/motor-denso.jpg',
            'category_id' => $motoresArranqueCategory->id,
            'is_active' => true
        ]);

        // Motor de arranque Denso DSN1 para vehículos medianos
        $motorArranqueMediano = Part::create([
            'name' => 'Motor de Arranque Denso DSN1',
            'code' => 'MAR-DENSO-DSN1',
            'description' => 'Motor de arranque Denso DSN1 para vehículos medianos. Potencia: 1.4kW. Voltaje: 12V. Dientes: 10. Incluye tornillos de montaje. Garantía de 2 años.',
            'price' => 169.99,
            'stock' => 15,
            'image_url' => '/images/parts/motor-denso.jpg',
            'category_id' => $motoresArranqueCategory->id,
            'is_active' => true
        ]);

        // Motor de arranque Denso DSN1 para vehículos premium
        $motorArranquePremium = Part::create([
            'name' => 'Motor de Arranque Denso DSN1 Premium',
            'code' => 'MAR-DENSO-DSN1P',
            'description' => 'Motor de arranque Denso DSN1 Premium para vehículos premium. Potencia: 1.6kW. Voltaje: 12V. Dientes: 11. Incluye tornillos de montaje. Garantía de 2 años.',
            'price' => 189.99,
            'stock' => 10,
            'image_url' => '/images/parts/motor-denso2.jpg',
            'category_id' => $motoresArranqueCategory->id,
            'is_active' => true
        ]);

        // Relacionar motores de arranque con modelos específicos
        $modelosCompactos = CarModel::whereIn('name', ['Golf', 'A3', 'León'])->get();
        $motorArranqueCompacto->models()->attach($modelosCompactos->pluck('id'));

        $modelosMedianos = CarModel::whereIn('name', ['Passat', 'A4', 'Toledo'])->get();
        $motorArranqueMediano->models()->attach($modelosMedianos->pluck('id'));

        $modelosPremium = CarModel::whereIn('name', ['A6', 'Serie 5', 'Clase E'])->get();
        $motorArranquePremium->models()->attach($modelosPremium->pluck('id'));
    }
}
