<?php

namespace Database\Seeders;

use App\Models\CarModel;
use Illuminate\Database\Seeder;

class CarModelSeeder extends Seeder
{
    public function run(): void
    {
        // Volkswagen
        CarModel::create([
            'name' => 'Golf',
            'brand' => 'Volkswagen',
            'year_start' => 2019,
            'year_end' => 2023,
            'description' => 'Volkswagen Golf 2019-2023'
        ]);

        CarModel::create([
            'name' => 'Passat',
            'brand' => 'Volkswagen',
            'year_start' => 2019,
            'year_end' => 2023,
            'description' => 'Volkswagen Passat 2019-2023'
        ]);

        CarModel::create([
            'name' => 'Tiguan',
            'brand' => 'Volkswagen',
            'year_start' => 2020,
            'year_end' => 2023,
            'description' => 'Volkswagen Tiguan 2020-2023'
        ]);

        // Audi
        CarModel::create([
            'name' => 'A3',
            'brand' => 'Audi',
            'year_start' => 2020,
            'year_end' => 2023,
            'description' => 'Audi A3 2020-2023'
        ]);

        CarModel::create([
            'name' => 'A4',
            'brand' => 'Audi',
            'year_start' => 2019,
            'year_end' => 2023,
            'description' => 'Audi A4 2019-2023'
        ]);

        CarModel::create([
            'name' => 'A6',
            'brand' => 'Audi',
            'year_start' => 2019,
            'year_end' => 2023,
            'description' => 'Audi A6 2019-2023'
        ]);

        CarModel::create([
            'name' => 'Q3',
            'brand' => 'Audi',
            'year_start' => 2020,
            'year_end' => 2023,
            'description' => 'Audi Q3 2020-2023'
        ]);

        CarModel::create([
            'name' => 'Q5',
            'brand' => 'Audi',
            'year_start' => 2020,
            'year_end' => 2023,
            'description' => 'Audi Q5 2020-2023'
        ]);

        CarModel::create([
            'name' => 'RS3',
            'brand' => 'Audi',
            'year_start' => 2021,
            'year_end' => 2023,
            'description' => 'Audi RS3 2021-2023'
        ]);

        // BMW
        CarModel::create([
            'name' => 'Serie 3',
            'brand' => 'BMW',
            'year_start' => 2019,
            'year_end' => 2023,
            'description' => 'BMW Serie 3 2019-2023'
        ]);

        CarModel::create([
            'name' => 'Serie 5',
            'brand' => 'BMW',
            'year_start' => 2020,
            'year_end' => 2023,
            'description' => 'BMW Serie 5 2020-2023'
        ]);

        CarModel::create([
            'name' => 'M3',
            'brand' => 'BMW',
            'year_start' => 2021,
            'year_end' => 2023,
            'description' => 'BMW M3 2021-2023'
        ]);

        // Mercedes
        CarModel::create([
            'name' => 'Clase C',
            'brand' => 'Mercedes',
            'year_start' => 2021,
            'year_end' => 2023,
            'description' => 'Mercedes Clase C 2021-2023'
        ]);

        CarModel::create([
            'name' => 'Clase E',
            'brand' => 'Mercedes',
            'year_start' => 2020,
            'year_end' => 2023,
            'description' => 'Mercedes Clase E 2020-2023'
        ]);

        CarModel::create([
            'name' => 'C63 AMG',
            'brand' => 'Mercedes',
            'year_start' => 2021,
            'year_end' => 2023,
            'description' => 'Mercedes C63 AMG 2021-2023'
        ]);

        // Seat
        CarModel::create([
            'name' => 'León',
            'brand' => 'Seat',
            'year_start' => 2020,
            'year_end' => 2023,
            'description' => 'Seat León 2020-2023'
        ]);

        CarModel::create([
            'name' => 'Ibiza',
            'brand' => 'Seat',
            'year_start' => 2020,
            'year_end' => 2023,
            'description' => 'Seat Ibiza 2020-2023'
        ]);

        CarModel::create([
            'name' => 'Ateca',
            'brand' => 'Seat',
            'year_start' => 2019,
            'year_end' => 2023,
            'description' => 'Seat Ateca 2019-2023'
        ]);

        CarModel::create([
            'name' => 'Toledo',
            'brand' => 'Seat',
            'year_start' => 2020,
            'year_end' => 2023,
            'description' => 'Seat Toledo 2020-2023'
        ]);
    }
}
