<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class BombasCombustibleSeeder extends Seeder
{
    public function run(): void
    {
        $bombasCategory = Category::where('name', 'Bombas de Combustible')->first();

        // Bomba de combustible Bosch para motores TDI
        $bombaBoschTDI = Part::create([
            'name' => 'Bomba de Combustible Bosch 0 580 254 910',
            'code' => 'BOM-BOSCH-TDI-910',
            'description' => 'Bomba de combustible Bosch para motores TDI. Bomba de alta presión para sistemas de inyección directa. Presión de trabajo: 1600 bar. Incluye filtro de combustible. Garantía de 2 años.',
            'price' => 299.99,
            'stock' => 12,
            'image_url' => '/images/parts/bomba-combustible-bosch.jpg',
            'category_id' => $bombasCategory->id,
            'is_active' => true
        ]);

        // Bomba de combustible Bosch para motores TFSI
        $bombaBoschTFSI = Part::create([
            'name' => 'Bomba de Combustible Bosch 0 580 254 911',
            'code' => 'BOM-BOSCH-TFSI-911',
            'description' => 'Bomba de combustible Bosch para motores TFSI. Bomba de alta presión para sistemas de inyección directa. Presión de trabajo: 200 bar. Incluye filtro de combustible y junta tórica. Garantía de 2 años.',
            'price' => 349.99,
            'stock' => 10,
            'image_url' => '/images/parts/bomba-combustible-bosch-2.jpg',
            'category_id' => $bombasCategory->id,
            'is_active' => true
        ]);

        // Bomba de combustible Bosch para motores de alta potencia
        $bombaBoschHP = Part::create([
            'name' => 'Bomba de Combustible Bosch 0 580 254 912',
            'code' => 'BOM-BOSCH-HP-912',
            'description' => 'Bomba de combustible Bosch para motores de alta potencia. Bomba de alta presión para sistemas de inyección directa. Presión de trabajo: 250 bar. Incluye filtro de combustible, junta tórica y tornillos de montaje. Garantía de 2 años.',
            'price' => 399.99,
            'stock' => 8,
            'image_url' => '/images/parts/bomba-combustible-bosch-3.jpg',
            'category_id' => $bombasCategory->id,
            'is_active' => true
        ]);

        // Relacionar bombas con modelos específicos
        $modelosTDI = CarModel::whereIn('name', ['Passat', 'A4', 'León'])->get();
        $bombaBoschTDI->models()->attach($modelosTDI->pluck('id'));

        $modelosTFSI = CarModel::whereIn('name', ['A3', 'Golf', 'Ibiza'])->get();
        $bombaBoschTFSI->models()->attach($modelosTFSI->pluck('id'));

        $modelosAltaPotencia = CarModel::whereIn('name', ['M3', 'C63 AMG', 'RS3'])->get();
        $bombaBoschHP->models()->attach($modelosAltaPotencia->pluck('id'));
    }
}
