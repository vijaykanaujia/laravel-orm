<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::factory(3)->create();
        $connection = 'sqlite';
        $cities = City::factory(3)->make();
        $cities->each(function ($model) use ($connection) {
            $model->setConnection($connection);
            $model->save();
        });
    }
}
