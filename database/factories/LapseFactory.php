<?php

namespace Database\Factories;

use App\Models\Lapse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lapse>
 */
class LapseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company,
            'interval' => fake()->numberBetween(1, 60),
            'is_paused' => false,
        ];
    }
}
