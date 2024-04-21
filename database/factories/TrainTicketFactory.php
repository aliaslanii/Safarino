<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrainTicket>
 */
class TrainTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'adultPrice' => round(random_int(500000,8000000)),
            'arrivalDate' => fake()->dateTimeInInterval('+1week','+2week'),
            'arrivalTime' => fake()->time(),
            'departureDate' => fake()->dateTimeInInterval('+1week','+2week'),
            'departureTime' => fake()->time(),
            'capacity' => random_int(650,853),
            'trainnumber' => random_int(650,853),
            'railcompanie_id' => random_int(1,30),
            'isCompleted' => fake()->boolean(),
            'origin' => random_int(1,30),
            'destination' => random_int(1,30),
            'type' => fake()->randomElement(['4-seater-coupe','6-seater-coupe','4-row-hall']),
        ];
    }
}
