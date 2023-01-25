<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Image::factory(10)->create();
        $images = Image::factory(10)->make();
        $connection = 'sqlite';
        $images->each(function (Image $model) use ($connection) {
            $model->setConnection($connection);
            $model->save();
        });

    }
}
