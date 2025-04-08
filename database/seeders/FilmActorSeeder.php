<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Film;
use App\Models\Actor;


class FilmActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $films = Film::all();
        $actors = Actor::all();

        foreach ($films as $film) {
            $film->actors()->attach(
                $actors->random(3)->pluck('id')
            );
        }
    }
}
