<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i <= 10; $i++) { 
            DB::table('city_room')->insert([
                'city_id' => mt_rand(1, 3),
                'room_id' => mt_rand(1, 10)
            ]);
        }
    }
}
