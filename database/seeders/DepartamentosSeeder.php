<?php

namespace Database\Seeders;

use App\Models\Departamentos;
use Illuminate\Database\Seeder;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departamentos::factory()->count(3)->create();
    }
}
