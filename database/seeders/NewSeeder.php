<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class NewSeeder extends Seeder
{
    
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('news')->insert([
                'title' => $faker->sentence(6),
                'content' => $faker->paragraphs(5, true),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
