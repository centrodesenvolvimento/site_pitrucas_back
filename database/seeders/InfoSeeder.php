<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('info')->insert([
            'info' => json_encode([
                'email' => '',
                'email2' => '',
                'numero' => '',
                'numero2' => '',
                'localizacao' => '',
                'monthstats' => json_decode('[
    { "month": "Janeiro", "visits": 0 },
    { "month": "Fevereiro", "visits": 0 },
    { "month": "Março", "visits": 0 },
    { "month": "Abril", "visits": 0 },
    { "month": "Maio", "visits": 0 },
    { "month": "Junho", "visits": 0 },
    { "month": "Julho", "visits": 0 },
    { "month": "Agosto", "visits": 0 },
    { "month": "Setembro", "visits": 0 },
    { "month": "Outubro", "visits": 0 },
    { "month": "Novembro", "visits": 0 },
    { "month": "Dezembro", "visits": 0 }
]')
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
