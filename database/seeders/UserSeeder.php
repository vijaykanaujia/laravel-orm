<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(3)->create()
        ->each(function($user){
            $user->address()->save(Address::factory()->make());
        });
        $connection = 'sqlite';
        $users = User::factory(3)->make();
        $users->each(function ($model) use ($connection) {
            $model->setConnection($connection);
            $model->save();
            $model->address()->save(Address::factory()->make());
        });
    }
}
