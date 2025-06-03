<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class AmortiguadoresSeeder extends Seeder
{
    public function run(): void
    {
        $suspensionCategory = Category::where('name', 'Suspensión')->first();

        // Amortiguador Monroe Delantero (específico para Audi y BMW)
        $amortiguadorMonroeDelantero = Part::create([
            'name' => 'Amortiguador Delantero Monroe OESpectrum',
            'code' => 'AMT-MONROE-OES-F',
            'description' => 'Amortiguador delantero Monroe OESpectrum. Tecnología de válvula de doble tubo con sistema de control de aceite mejorado. Incluye juntas y tornillos de montaje. Compatible con vehículos de gama media y alta. Garantía de 2 años o 40.000 km. Certificado TÜV.',
            'price' => 89.99,
            'stock' => 20,
            'image_url' => '/images/parts/amortiguador-delantero.jpg',
            'category_id' => $suspensionCategory->id,
            'is_active' => true
        ]);

        // Amortiguador Monroe Trasero (específico para Audi y BMW)
        $amortiguadorMonroeTrasero = Part::create([
            'name' => 'Amortiguador Trasero Monroe Reflex',
            'code' => 'AMT-MONROE-REF-R',
            'description' => 'Amortiguador trasero Monroe Reflex. Sistema de respuesta rápida con válvula de control de flujo variable. Optimizado para mejor control en curvas. Incluye kit de montaje completo. Ideal para conducción deportiva. Garantía de 2 años o 35.000 km.',
            'price' => 79.99,
            'stock' => 18,
            'image_url' => '/images/parts/amortiguador-trasero.jpg',
            'category_id' => $suspensionCategory->id,
            'is_active' => true
        ]);

        // Amortiguador TRW TWIN (específico para Mercedes y BMW)
        $amortiguadorTRW = Part::create([
            'name' => 'Amortiguador TRW TWIN-TUBE',
            'code' => 'AMT-TRW-TWIN',
            'description' => 'Amortiguador TRW TWIN-TUBE. Sistema de doble tubo con tecnología de válvula progresiva. Diseñado para vehículos de alta gama. Incluye sistema de montaje rápido y kit completo de juntas. Optimizado para máximo confort y control. Garantía de 3 años o 60.000 km.',
            'price' => 149.99,
            'stock' => 12,
            'image_url' => '/images/parts/amortiguador-TRW.jpg',
            'category_id' => $suspensionCategory->id,
            'is_active' => true
        ]);

        // Relacionar los amortiguadores Monroe solo con Audi y BMW
        $modelosAudiBMW = CarModel::whereIn('brand', ['Audi', 'BMW'])->get();
        $amortiguadorMonroeDelantero->models()->attach($modelosAudiBMW->pluck('id'));
        $amortiguadorMonroeTrasero->models()->attach($modelosAudiBMW->pluck('id'));

        // Relacionar el amortiguador TRW con Mercedes y BMW
        $modelosMercedesBMW = CarModel::whereIn('brand', ['Mercedes', 'BMW'])->get();
        $amortiguadorTRW->models()->attach($modelosMercedesBMW->pluck('id'));

        // Amortiguador Sachs (específico para Mercedes)
        $amortiguadorSachs = Part::create([
            'name' => 'Amortiguador Delantero Sachs Performance',
            'code' => 'AMT-SACHS-PERF-F',
            'description' => 'Amortiguador delantero Sachs Performance. Sistema de amortiguación deportiva con válvula de presión variable. Incluye kit de montaje completo. Optimizado para vehículos de alta gama. Garantía de 2 años o 50.000 km.',
            'price' => 129.99,
            'stock' => 15,
            'image_url' => '/images/parts/amortiguador-sech.jpg',
            'category_id' => $suspensionCategory->id,
            'is_active' => true
        ]);

        // Relacionar el amortiguador Sachs solo con Mercedes
        $modelosMercedes = CarModel::where('brand', 'Mercedes')->get();
        $amortiguadorSachs->models()->attach($modelosMercedes->pluck('id'));

        // Amortiguador KYB (específico para Volkswagen y Seat)
        $amortiguadorKYB = Part::create([
            'name' => 'Amortiguador Delantero KYB Excel-G',
            'code' => 'AMT-KYB-EXG-F',
            'description' => 'Amortiguador delantero KYB Excel-G. Tecnología de gas a presión con válvula de control de flujo. Incluye tornillos y juntas. Ideal para uso diario. Garantía de 2 años o 30.000 km.',
            'price' => 69.99,
            'stock' => 25,
            'image_url' => '/images/parts/amortiguador-kyb.jpg',
            'category_id' => $suspensionCategory->id,
            'is_active' => true
        ]);

        // Relacionar el amortiguador KYB solo con Volkswagen y Seat
        $modelosVWSeat = CarModel::whereIn('brand', ['Volkswagen', 'Seat'])->get();
        $amortiguadorKYB->models()->attach($modelosVWSeat->pluck('id'));
    }
}
