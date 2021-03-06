<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\User::factory(12)->create();
        \App\Models\Cuenta::factory(12)->create();
        \App\Models\Prestamo::factory(12)->create();
        \App\Models\Historial_de_pago::factory(12)->create();
    }

}
