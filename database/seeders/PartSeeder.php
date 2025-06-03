<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PartSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AlternadoresSeeder::class,
            BateriasSeeder::class,
            BobinasEncendidoSeeder::class,
            BombasAguaSeeder::class,
            BombasCombustibleSeeder::class,
            BujiasEncendidoSeeder::class,
            CentralitasSeeder::class,
            CompresoresAireSeeder::class,
            CorreasDistribucionSeeder::class,
            DiscosFrenoSeeder::class,
            EmbraguesSeeder::class,
            EscobillasSeeder::class,
            FiltrosAceiteSeeder::class,
            FiltrosAireSeeder::class,
            FiltrosCombustibleSeeder::class,
            FiltrosHabitaculoSeeder::class,
            TermostatosSeeder::class,
            MotoresArranqueSeeder::class,
            AmortiguadoresSeeder::class,
        ]);
    }
}
