<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class BombasAguaSeeder extends Seeder
{
    public function run(): void
    {
        $bombasCategory = Category::where('name', 'Bombas de Agua')->first();

        // Bomba de agua SKF VKPC
        $bombaSKF = Part::create([
            'name' => 'Bomba de Agua SKF VKPC 10-1234',
            'code' => 'BOM-SKF-VKPC',
            'description' => 'Bomba de agua SKF VKPC con rodamiento sellado de por vida. Impulsor de plástico de alta resistencia. Compatible con sistemas de refrigeración modernos. Incluye junta tórica. Garantía de 2 años.',
            'price' => 149.99,
            'stock' => 18,
            'image_url' => '/images/parts/bomba-agua-SKF.jpg',
            'category_id' => $bombasCategory->id,
            'is_active' => true
        ]);

        // Bomba de agua Gates
        $bombaGates = Part::create([
            'name' => 'Bomba de Agua Gates 42137',
            'code' => 'BOM-GATES-42137',
            'description' => 'Bomba de agua Gates con rodamiento de alta durabilidad. Impulsor de acero inoxidable. Compatible con sistemas de refrigeración de alta presión. Incluye kit de montaje completo. Garantía de 2 años.',
            'price' => 129.99,
            'stock' => 22,
            'image_url' => '/images/parts/bomba-agua-gates.jpg',
            'category_id' => $bombasCategory->id,
            'is_active' => true
        ]);

        // Bomba de agua Continental
        $bombaContinental = Part::create([
            'name' => 'Bomba de Agua Continental 5WK96001',
            'code' => 'BOM-CONT-5WK96001',
            'description' => 'Bomba de agua Continental con tecnología de sellado mejorada. Impulsor de composite reforzado. Compatible con sistemas de refrigeración de última generación. Incluye tornillos de montaje. Garantía de 2 años.',
            'price' => 169.99,
            'stock' => 15,
            'image_url' => '/images/parts/bomba-agua-continental.jpg',
            'category_id' => $bombasCategory->id,
            'is_active' => true
        ]);

        // Relacionar bombas con modelos específicos
        $modelosSKF = CarModel::whereIn('name', ['Golf', 'A3', 'León'])->get();
        $bombaSKF->models()->attach($modelosSKF->pluck('id'));

        $modelosGates = CarModel::whereIn('name', ['Serie 3', 'Clase C'])->get();
        $bombaGates->models()->attach($modelosGates->pluck('id'));

        $modelosContinental = CarModel::whereIn('name', ['A4', 'Passat'])->get();
        $bombaContinental->models()->attach($modelosContinental->pluck('id'));
    }
}
