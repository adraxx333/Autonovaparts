<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class CompresoresAireSeeder extends Seeder
{
    public function run(): void
    {
        $compresoresCategory = Category::where('name', 'Compresores de Aire Acondicionado')->first();

        // Compresor Denso para vehículos compactos
        $compresorDenso = Part::create([
            'name' => 'Compresor Aire Acondicionado Denso 471-1410',
            'code' => 'COM-DENSO-1410',
            'description' => 'Compresor de aire acondicionado Denso para vehículos compactos. Tipo: Scroll. Refrigerante: R134a. Incluye embrague electromagnético. Garantía de 2 años.',
            'price' => 299.99,
            'stock' => 15,
            'image_url' => '/images/parts/compresor-aire-denso.jpg',
            'category_id' => $compresoresCategory->id,
            'is_active' => true
        ]);

        // Compresor Sanden para vehículos medianos
        $compresorSanden = Part::create([
            'name' => 'Compresor Aire Acondicionado Sanden SD7H15',
            'code' => 'COM-SANDEN-SD7H15',
            'description' => 'Compresor de aire acondicionado Sanden para vehículos medianos. Tipo: Piston. Refrigerante: R134a/R1234yf. Incluye embrague y válvula de control. Garantía de 2 años.',
            'price' => 349.99,
            'stock' => 12,
            'image_url' => '/images/parts/compresor-aire-sanden.jpg',
            'category_id' => $compresoresCategory->id,
            'is_active' => true
        ]);

        // Compresor Valeo para vehículos premium
        $compresorValeo = Part::create([
            'name' => 'Compresor Aire Acondicionado Valeo 5PK',
            'code' => 'COM-VALEO-5PK',
            'description' => 'Compresor de aire acondicionado Valeo para vehículos premium. Tipo: Scroll. Refrigerante: R1234yf. Incluye embrague, válvula de control y aceite PAG. Garantía de 2 años.',
            'price' => 399.99,
            'stock' => 10,
            'image_url' => '/images/parts/compresor-aire-valeo.png',
            'category_id' => $compresoresCategory->id,
            'is_active' => true
        ]);

        // Relacionar compresores con modelos específicos
        $modelosCompactos = CarModel::whereIn('name', ['Volkswagen Golf', 'Audi A3', 'Seat Leon'])->get();
        $compresorDenso->models()->attach($modelosCompactos->pluck('id'));

        $modelosMedianos = CarModel::whereIn('name', ['Volkswagen Passat', 'Audi A4', 'Seat Toledo'])->get();
        $compresorSanden->models()->attach($modelosMedianos->pluck('id'));

        $modelosPremium = CarModel::whereIn('name', ['Audi A6', 'BMW Serie 5', 'Mercedes Clase E'])->get();
        $compresorValeo->models()->attach($modelosPremium->pluck('id'));
    }
}
