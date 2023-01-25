<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(CompanySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(ReservationSeeder::class);
        // $this->call(AddressSeeder::class);
        $this->call(CityRoomSeeder::class);
        $this->call(ImageSeeder::class);
    }
}
