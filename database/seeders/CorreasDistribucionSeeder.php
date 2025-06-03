<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\Category;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class CorreasDistribucionSeeder extends Seeder
{
    public function run(): void
    {
        $correasCategory = Category::where('name', 'Correas de Distribución')->first();

        // Kit de distribución Contitech para vehículos compactos
        $kitContitechCompacto = Part::create([
            'name' => 'Kit de Distribución Contitech CT 1001',
            'code' => 'COR-CONT-CT1001',
            'description' => 'Kit de distribución Contitech para vehículos compactos. Incluye: Correa, Tensor, Rodillos y Bomba de agua. Garantía de 2 años.',
            'price' => 149.99,
            'stock' => 20,
            'image_url' => '/images/parts/kit-distribucion-ct.jpg',
            'category_id' => $correasCategory->id,
            'is_active' => true
        ]);

        // Kit de distribución Contitech para vehículos medianos
        $kitContitechMediano = Part::create([
            'name' => 'Kit de Distribución Contitech CT 1002',
            'code' => 'COR-CONT-CT1002',
            'description' => 'Kit de distribución Contitech para vehículos medianos. Incluye: Correa, Tensor, Rodillos y Bomba de agua. Garantía de 2 años.',
            'price' => 179.99,
            'stock' => 15,
            'image_url' => '/images/parts/kit-distribucion-dayco.png',
            'category_id' => $correasCategory->id,
            'is_active' => true
        ]);

        // Kit de distribución Contitech para vehículos premium
        $kitContitechPremium = Part::create([
            'name' => 'Kit de Distribución Contitech CT 1003',
            'code' => 'COR-CONT-CT1003',
            'description' => 'Kit de distribución Contitech para vehículos premium. Incluye: Correa, Tensor, Rodillos y Bomba de agua. Garantía de 2 años.',
            'price' => 209.99,
            'stock' => 10,
            'image_url' => '/images/parts/kit-distribucion.jpg',
            'category_id' => $correasCategory->id,
            'is_active' => true
        ]);

        // Kit de distribución ContiTech para motores TDI
        $kitContiTechTDI = Part::create([
            'name' => 'Kit Distribución ContiTech CT1041',
            'code' => 'COR-CONTITECH-TDI-1041',
            'description' => 'Kit de distribución ContiTech para motores TDI. Incluye correa de distribución, tensor, rodillo tensor y bomba de agua. Material: HNBR. Garantía de 2 años.',
            'price' => 189.99,
            'stock' => 20,
            'image_url' => '/images/parts/kit-distribucion.jpg',
            'category_id' => $correasCategory->id,
            'is_active' => true
        ]);

        // Kit de distribución ContiTech para motores TFSI
        $kitContiTechTFSI = Part::create([
            'name' => 'Kit Distribución ContiTech CT1052',
            'code' => 'COR-CONTITECH-TFSI-1052',
            'description' => 'Kit de distribución ContiTech para motores TFSI. Incluye correa de distribución, tensor, rodillo tensor, bomba de agua y tornillos. Material: HNBR. Garantía de 2 años.',
            'price' => 199.99,
            'stock' => 18,
            'image_url' => '/images/parts/kit-distribucion.jpg',
            'category_id' => $correasCategory->id,
            'is_active' => true
        ]);

        // Kit de distribución Dayco para motores TDI
        $kitDaycoTDI = Part::create([
            'name' => 'Kit Distribución Dayco DT1041',
            'code' => 'COR-DAYCO-TDI-1041',
            'description' => 'Kit de distribución Dayco para motores TDI. Incluye correa de distribución, tensor, rodillo tensor y bomba de agua. Material: HNBR. Garantía de 2 años.',
            'price' => 179.99,
            'stock' => 22,
            'image_url' => '/images/parts/kit-distribucion-dayco.png',
            'category_id' => $correasCategory->id,
            'is_active' => true
        ]);

        // Kit de distribución Dayco para motores TFSI
        $kitDaycoTFSI = Part::create([
            'name' => 'Kit Distribución Dayco DT1052',
            'code' => 'COR-DAYCO-TFSI-1052',
            'description' => 'Kit de distribución Dayco para motores TFSI. Incluye correa de distribución, tensor, rodillo tensor, bomba de agua y tornillos. Material: HNBR. Garantía de 2 años.',
            'price' => 189.99,
            'stock' => 20,
            'image_url' => '/images/parts/kit-distribucion-dayco.png',
            'category_id' => $correasCategory->id,
            'is_active' => true
        ]);

        // Relacionar kits con modelos específicos
        $modelosCompactos = CarModel::whereIn('name', ['Golf', 'A3', 'León'])->get();
        $kitContitechCompacto->models()->attach($modelosCompactos->pluck('id'));

        $modelosMedianos = CarModel::whereIn('name', ['Passat', 'A4', 'Toledo'])->get();
        $kitContitechMediano->models()->attach($modelosMedianos->pluck('id'));

        $modelosPremium = CarModel::whereIn('name', ['A6', 'Serie 5', 'Clase E'])->get();
        $kitContitechPremium->models()->attach($modelosPremium->pluck('id'));

        $modelosTDI = CarModel::whereIn('name', ['Passat', 'A4', 'León'])->get();
        $kitContiTechTDI->models()->attach($modelosTDI->pluck('id'));
        $kitDaycoTDI->models()->attach($modelosTDI->pluck('id'));

        $modelosTFSI = CarModel::whereIn('name', ['A3', 'Golf', 'Ibiza'])->get();
        $kitContiTechTFSI->models()->attach($modelosTFSI->pluck('id'));
        $kitDaycoTFSI->models()->attach($modelosTFSI->pluck('id'));
    }
}
