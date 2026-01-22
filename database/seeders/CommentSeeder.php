<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;                  // ← Import Faker
use App\Models\News;                         // ← Import model News
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $newsList = News::all();

        foreach ($newsList as $news){
            $count = rand(2,6);
            for ($i=0; $i < $count; $i++){
                Comment::create([
                    'news_id' => $news->id,
                    'title' => $faker->optional()->sentence(3),
                    'content' => $faker->paragraph(2),
                    'author_id' => null,
                ]);
            }
        }
    }
}
