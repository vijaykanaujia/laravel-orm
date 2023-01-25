<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Address::factory(3)->create();
        $connection = 'sqlite';
        $addresses = Address::factory(3)->make();
        $addresses->each(function ($model) use ($connection) {
            $model->setConnection($connection);
            $model->save();
        });
    }
}
