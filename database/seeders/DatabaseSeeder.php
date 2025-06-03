<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Crear usuario de prueba
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Ejecutar seeders en orden
        $this->call([
            CategorySeeder::class,    // Primero las categorías
            CarModelSeeder::class,    // Luego los modelos de coches
            PartSeeder::class,        // Finalmente las partes
        ]);
    }
}
