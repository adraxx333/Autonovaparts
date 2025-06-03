<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class BobinasEncendidoSeeder extends Seeder
{
    public function run(): void
    {
        $bobinasCategory = Category::where('name', 'Bobinas de Encendido')->first();

        // Bobina Bosch para motores TFSI
        $bobinaBosch = Part::create([
            'name' => 'Bobina de Encendido Bosch 0221504470',
            'code' => 'BOB-BOSCH-TFSI',
            'description' => 'Bobina de encendido Bosch para motores TFSI. Compatible con sistemas de encendido directo. Alta tensión de salida para bujías de iridio. Resistente a altas temperaturas. Garantía de 2 años.',
            'price' => 89.99,
            'stock' => 20,
            'image_url' => '/images/parts/bobina-encendido-bosch.jpg',
            'category_id' => $bobinasCategory->id,
            'is_active' => true
        ]);

        // Bobina NGK para motores TDI
        $bobinaNGK = Part::create([
            'name' => 'Bobina de Encendido NGK U5051',
            'code' => 'BOB-NGK-TDI',
            'description' => 'Bobina de encendido NGK para motores TDI. Diseño compacto y eficiente. Excelente aislamiento térmico. Compatible con sistemas de inyección directa. Garantía de 2 años.',
            'price' => 79.99,
            'stock' => 25,
            'image_url' => '/images/parts/bobina-encendido-NGK.jpg',
            'category_id' => $bobinasCategory->id,
            'is_active' => true
        ]);

        // Bobina Beru para motores de alta potencia
        $bobinaBeru = Part::create([
            'name' => 'Bobina de Encendido Beru ZSE038',
            'code' => 'BOB-BERU-HP',
            'description' => 'Bobina de encendido Beru para motores de alta potencia. Tecnología de doble chispa. Alta eficiencia energética. Compatible con sistemas de encendido múltiple. Garantía de 2 años.',
            'price' => 129.99,
            'stock' => 15,
            'image_url' => '/images/parts/bobina-encendido-beru.jpg',
            'category_id' => $bobinasCategory->id,
            'is_active' => true
        ]);

        // Relacionar bobinas con modelos específicos
        $modelosTFSI = CarModel::whereIn('name', ['A3', 'Golf', 'León'])->get();
        $bobinaBosch->models()->attach($modelosTFSI->pluck('id'));

        $modelosTDI = CarModel::whereIn('name', ['Passat', 'A4', 'León'])->get();
        $bobinaNGK->models()->attach($modelosTDI->pluck('id'));

        $modelosAltaPotencia = CarModel::whereIn('name', ['M3', 'C63 AMG', 'RS3'])->get();
        $bobinaBeru->models()->attach($modelosAltaPotencia->pluck('id'));
    }
}
