<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reservation::factory(10)->create();
        
        $models = Reservation::factory(10)->make();
        foreach($models as $model){
            $model->setConnection('sqlite');
            $model->save();
        }
    }
}
