<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Actor;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Actor>
 */
class ActorFactory extends Factory
{
    protected $model = Actor::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'birthdate' => $this->faker->date('Y-m-d', '2000-01-01'),
            'country' => substr($this->faker->country(), 0, 30),
            'img_url' => $this->faker->imageUrl(200, 200, 'people')
        ];
    }
}