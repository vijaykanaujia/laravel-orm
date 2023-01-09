<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Room::factory(10)->create();
        
        $models = Room::factory(10)->make();
        foreach($models as $model){
            $model->setConnection('sqlite');
            $model->save();
        }
    }
}
