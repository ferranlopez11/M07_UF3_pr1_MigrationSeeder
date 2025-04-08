<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Film;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Film>
 */
class FilmFactory extends Factory
{
    protected $model = Film::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->sentence(3),
            'year' => $this->faker->numberBetween(1900, 2024),
            'genre' => $this->faker->randomElement(['Acción', 'Ciencia ficción', 'Drama', 'Comedia', 'Terror', 'Romance', 'Thriller']),
            'country' => substr($this->faker->country(), 0, 30),
            'duration' => $this->faker->numberBetween(60, 180),
            'img_url' => $this->faker->imageUrl(640, 480, 'movies')
        ];
    }
}
