<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class films extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        $genres = ['Acción', 'Ciencia ficción', 'Drama', 'Comedia', 'Terror', 'Romance'];

        for ($i = 0; $i < 10; $i++) {
            DB::table('films')->insert([
                'name' => $faker->unique()->sentence(3),
                'year' => $faker->numberBetween(1900, 2024),
                'genre' => $faker->randomElement($genres),
                'country' => substr($faker->country(), 0, 30),
                'duration' => $faker->numberBetween(60, 180),
                'img_url' => $faker->imageUrl(640, 480, 'movies'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
