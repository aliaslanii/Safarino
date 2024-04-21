<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $Vehicle = ['قطار','هواپیما','اتوبوس','اقامتگاه'];
        return [
            'type' => $Vehicle[random_int(0,3)]
        ];
    }
}
