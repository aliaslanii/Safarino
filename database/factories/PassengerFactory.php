<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Passenger>
 */
class PassengerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstName' => fake()->firstName(),
            'lastName' => fake()->lastName(),
            'birthday' => fake()->date(),
            'nationalcode' => Str::random(11,'0123456789'),
            'gender' => fake()->randomElement(['femail','male']),
            'user_id' => 1,
        ];
    }
}
