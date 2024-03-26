<?php

namespace Database\Factories;

use App\Models\Camera;
use App\Models\Lapse;
use App\Models\Snapshot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Snapshot>
 */
class SnapshotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lapse_id' => Lapse::factory(),
            'camera_id' => Camera::factory(),
            'path' => fake()->md5.'.jpg',
        ];
    }
}
