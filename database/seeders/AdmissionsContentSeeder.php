<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdmissionsContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admissions_contents')->insert([
            'emolumentos' => null,
            'calendario' => null,
            'exames' => json_encode([

            ]),
            'perguntas' => json_encode([

            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
