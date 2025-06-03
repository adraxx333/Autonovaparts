<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class CentralitasSeeder extends Seeder
{
    public function run(): void
    {
        $centralitasCategory = Category::where('name', 'Centralitas')->first();

        // Centralita Start-Stop Comforser CF30
        $centralitaStartStop = Part::create([
            'name' => 'Centralita Start-Stop Comforser CF30',
            'code' => 'CEN-COMFORSER-CF30',
            'description' => 'Centralita Start-Stop Comforser CF30. Sistema de gestión de arranque y parada automática. Compatible con sistemas de batería AGM y EFB. Incluye cableado y conectores. Garantía de 2 años.',
            'price' => 89.99,
            'stock' => 25,
            'image_url' => '/images/parts/centralita-start-stop.jpg',
            'category_id' => $centralitasCategory->id,
            'is_active' => true
        ]);

        // Relacionar centralita con modelos específicos
        $modelosCompatibles = CarModel::whereIn('name', [
            'Golf',
            'A3',
            'León',
            'Tiguan',
            'Q3',
            'Ateca'
        ])->get();

        $centralitaStartStop->models()->attach($modelosCompatibles->pluck('id'));
    }
}
