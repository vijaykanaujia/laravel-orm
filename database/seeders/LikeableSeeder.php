<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikeableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            DB::table('likeables')->insert([
                'user_id' => mt_rand(1, 3),
                'likeable_id' => mt_rand(1, 10),
                'likeable_type' => [Image::class, Room::class][mt_rand(0, 1)],
            ]);
            DB::connection('sqlite')->table('likeables')->insert([
                'user_id' => mt_rand(1, 3),
                'likeable_id' => mt_rand(1, 10),
                'likeable_type' => [Image::class, Room::class][mt_rand(0, 1)],
            ]);
        }
    }
}
