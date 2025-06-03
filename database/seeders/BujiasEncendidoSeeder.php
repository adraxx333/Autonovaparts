<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class BujiasEncendidoSeeder extends Seeder
{
    public function run(): void
    {
        $bujiasCategory = Category::where('name', 'Bujías de Encendido')->first();

        // Bujía NGK Iridium IX para motores de gasolina
        $bujiaNGKIridium = Part::create([
            'name' => 'Bujía NGK Iridium IX BKR6EIX',
            'code' => 'BUJ-NGK-IRIDIUM-IX',
            'description' => 'Bujía NGK Iridium IX para motores de gasolina. Electrodo central de iridio para mayor durabilidad. Rango térmico: 6. Gap: 0.8mm. Compatible con sistemas de encendido directo. Garantía de 2 años.',
            'price' => 12.99,
            'stock' => 100,
            'image_url' => '/images/parts/bujia-NGK.jpg',
            'category_id' => $bujiasCategory->id,
            'is_active' => true
        ]);

        // Bujía NGK Laser Iridium para motores de alto rendimiento
        $bujiaNGKLaser = Part::create([
            'name' => 'Bujía NGK Laser Iridium SILZKBR8D8S',
            'code' => 'BUJ-NGK-LASER-IRIDIUM',
            'description' => 'Bujía NGK Laser Iridium para motores de alto rendimiento. Tecnología de doble iridio. Rango térmico: 8. Gap: 0.8mm. Diseño de punta fina para mejor ignición. Garantía de 2 años.',
            'price' => 19.99,
            'stock' => 75,
            'image_url' => '/images/parts/bujia-NGK-LASER.png',
            'category_id' => $bujiasCategory->id,
            'is_active' => true
        ]);

        // Bujía NGK Ruthenium para motores modernos
        $bujiaNGKRuthenium = Part::create([
            'name' => 'Bujía NGK Ruthenium HX RUTHLX',
            'code' => 'BUJ-NGK-RUTHENIUM',
            'description' => 'Bujía NGK Ruthenium para motores modernos. Electrodo central de rutenio para máxima durabilidad. Rango térmico: 7. Gap: 0.7mm. Optimizada para motores con inyección directa. Garantía de 2 años.',
            'price' => 15.99,
            'stock' => 90,
            'image_url' => '/images/parts/bujia-NGK-rutherium.jpg',
            'category_id' => $bujiasCategory->id,
            'is_active' => true
        ]);

        // Relacionar bujías con modelos específicos
        $modelosGasolina = CarModel::whereIn('name', ['Golf', 'A3', 'León'])->get();
        $bujiaNGKIridium->models()->attach($modelosGasolina->pluck('id'));

        $modelosAltoRendimiento = CarModel::whereIn('name', ['M3', 'C63 AMG', 'RS3'])->get();
        $bujiaNGKLaser->models()->attach($modelosAltoRendimiento->pluck('id'));

        $modelosModernos = CarModel::whereIn('name', ['Tiguan', 'Q5', 'Ateca'])->get();
        $bujiaNGKRuthenium->models()->attach($modelosModernos->pluck('id'));
    }
}
