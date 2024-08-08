<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date_time = new DateTime();
        DB::table('users')->insert([
            'level' => 0,
            'name' => 'Super Admin',
            'email' => 'superAdmin@gmail.com',
            'password' => Hash::make('123456'),
            'status' =>'activo',
            'created_at' => $date_time,
            'updated_at' => $date_time,
        ]);
    }
}
