<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('about_contents')->insert([
            [
                'video' => null,
                'somos' => 'example_somos_data',
                'missao' => 'example_missao_data',
                'visao' => 'example_visao_data',
                'valores' => json_encode([

                ]),
                'orgaos_singulares' => json_encode([

                ]),
                'orgaos_colegiais' => json_encode([

                ]),
                'administracao' => null,
                'historial' => json_encode([

                ]),
                'regulamentos' => json_encode([

                ]),
                'organigrama' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
