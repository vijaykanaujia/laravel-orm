<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::factory(10)->create();
        $connection = 'sqlite';
        $comments = Comment::factory(10)->make();
        $comments->each(function ($model) use ($connection) {
            $model->setConnection($connection);
            $model->save();
        });
    }
}
