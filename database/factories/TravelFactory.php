<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Travel>
 */
class TravelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'from' => random_int(1,30),
            'to' => random_int(1,30),
            'date' => Fake()->date(),
            'time' => Fake()->time(),
            'vehicle_id' => random_int(1,3)
        ];
    }
}
