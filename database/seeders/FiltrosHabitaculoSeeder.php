<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class FiltrosHabitaculoSeeder extends Seeder
{
    public function run(): void
    {
        $filtrosHabitaculoCategory = Category::where('name', 'Filtros de Habitáculo')->first();

        // Filtro de habitáculo Mann para vehículos compactos
        $filtroHabitaculoCompacto = Part::create([
            'name' => 'Filtro de Habitáculo Mann CU 25 011',
            'code' => 'FIL-HAB-MANN-CU25011',
            'description' => 'Filtro de habitáculo Mann para vehículos compactos. Dimensiones: 250x200x30mm. Material: Carbón activo. Garantía de 1 año.',
            'price' => 24.99,
            'stock' => 70,
            'image_url' => '/images/parts/filtro-habitaculo-mann.jpg',
            'category_id' => $filtrosHabitaculoCategory->id,
            'is_active' => true
        ]);

        // Filtro de habitáculo Mann para vehículos medianos
        $filtroHabitaculoMediano = Part::create([
            'name' => 'Filtro de Habitáculo Mann CU 30 011',
            'code' => 'FIL-HAB-MANN-CU30011',
            'description' => 'Filtro de habitáculo Mann para vehículos medianos. Dimensiones: 300x250x30mm. Material: Carbón activo. Garantía de 1 año.',
            'price' => 27.99,
            'stock' => 60,
            'image_url' => '/images/parts/filtro-habitaculo-mann.jpg',
            'category_id' => $filtrosHabitaculoCategory->id,
            'is_active' => true
        ]);

        // Filtro de habitáculo Mann para vehículos premium
        $filtroHabitaculoPremium = Part::create([
            'name' => 'Filtro de Habitáculo Mann CU 35 011',
            'code' => 'FIL-HAB-MANN-CU35011',
            'description' => 'Filtro de habitáculo Mann para vehículos premium. Dimensiones: 350x300x30mm. Material: Carbón activo. Garantía de 1 año.',
            'price' => 30.99,
            'stock' => 50,
            'image_url' => '/images/parts/filtro-habitaculo-mann.jpg',
            'category_id' => $filtrosHabitaculoCategory->id,
            'is_active' => true
        ]);

        // Relacionar filtros con modelos específicos
        $modelosCompactos = CarModel::whereIn('name', ['Golf', 'A3', 'León'])->get();
        $filtroHabitaculoCompacto->models()->attach($modelosCompactos->pluck('id'));

        $modelosMedianos = CarModel::whereIn('name', ['Passat', 'A4', 'Toledo'])->get();
        $filtroHabitaculoMediano->models()->attach($modelosMedianos->pluck('id'));

        $modelosPremium = CarModel::whereIn('name', ['A6', 'Serie 5', 'Clase E'])->get();
        $filtroHabitaculoPremium->models()->attach($modelosPremium->pluck('id'));
    }
}
