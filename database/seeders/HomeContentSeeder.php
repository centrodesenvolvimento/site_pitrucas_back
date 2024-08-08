<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date_time = new DateTime();

        DB::table('home_contents')->insert([
            'videoInicial' => null,
            'imagemPr' => null,
            'mensagemPr' => 'This is a sample message.',
            'perfilPr' => null,
            'testemunhos' => json_encode([
                
            ]),
            'created_at' => $date_time,
            'updated_at' => $date_time,
        ]);
    }
}
