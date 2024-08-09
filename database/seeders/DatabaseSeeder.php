<?php

namespace Database\Seeders;

use App\Models\AdmissionsContent;
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
        $this->call([
            UserSeeder::class,
            AboutContentSeeder::class,

            HomeContentSeeder::class,
            AdmissionsContentSeeder::class,
            DepartamentosSeeder::class,
            InfoSeeder::class,
            NewsSeeder::class

        ]);


    }
}
