<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AwardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $actorIds = DB::table('actors')->pluck('id');
        
        foreach ($actorIds as $actorId) {
            for ($i = 0; $i < $faker->numberBetween(1, 3); $i++) {
                DB::table('awards')->insert([
                    'actor_id' => $actorId,
                    'name' => $faker->randomElement(['Oscar', 'Globos de oro', 'Goya', 'Emmy']),
                    'year' => $faker->numberBetween(2000, 2023),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
