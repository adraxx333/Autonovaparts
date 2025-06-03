<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class BateriasSeeder extends Seeder
{
    public function run(): void
    {
        $bateriasCategory = Category::where('name', 'Baterías')->first();

        // Batería Bosch para vehículos compactos
        $bateriaBosch = Part::create([
            'name' => 'Batería Bosch S5 60Ah',
            'code' => 'BAT-BOSCH-S5-60',
            'description' => 'Batería Bosch S5 para vehículos compactos. 60Ah, 540A. Tecnología AGM. Compatible con sistemas Start-Stop. Garantía de 2 años.',
            'price' => 159.99,
            'stock' => 25,
            'image_url' => '/images/parts/bateria-bosch-S5.jpg',
            'category_id' => $bateriasCategory->id,
            'is_active' => true
        ]);

        // Batería Varta para vehículos SUV
        $bateriaVarta = Part::create([
            'name' => 'Batería Varta Blue Dynamic 70Ah',
            'code' => 'BAT-VARTA-BD-70',
            'description' => 'Batería Varta Blue Dynamic para vehículos SUV. 70Ah, 630A. Tecnología EFB. Compatible con sistemas Start-Stop. Garantía de 2 años.',
            'price' => 229.99,
            'stock' => 15,
            'image_url' => '/images/parts/bateria-varta-blue.png',
            'category_id' => $bateriasCategory->id,
            'is_active' => true
        ]);

        // Batería Exide para vehículos premium
        $bateriaExide = Part::create([
            'name' => 'Batería Exide Premium 80Ah',
            'code' => 'BAT-EXIDE-PREMIUM-80',
            'description' => 'Batería Exide Premium para vehículos de alta gama. 80Ah, 700A. Tecnología AGM. Compatible con sistemas Start-Stop y híbridos. Garantía de 2 años.',
            'price' => 119.99,
            'stock' => 30,
            'image_url' => '/images/parts/bateria-exide.jpg',
            'category_id' => $bateriasCategory->id,
            'is_active' => true
        ]);

        // Relacionar baterías con modelos específicos
        $modelosCompactos = CarModel::whereIn('name', ['Golf', 'A3', 'León'])->get();
        $bateriaBosch->models()->attach($modelosCompactos->pluck('id'));

        $modelosSUV = CarModel::whereIn('name', ['Tiguan', 'Q5', 'Ateca'])->get();
        $bateriaVarta->models()->attach($modelosSUV->pluck('id'));

        $modelosPremium = CarModel::whereIn('name', ['A6', 'Serie 5', 'Clase E'])->get();
        $bateriaExide->models()->attach($modelosPremium->pluck('id'));
    }
}
