<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AirplaneTicket>
 */
class AirplaneTicketFactory extends Factory
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
            'aircraft' => fake()->firstName(),
            'maxAllowedBaggage' => random_int(20,30),
            'flightNumber' => random_int(650,853),
            'airport_id' => random_int(1,30),
            'isCompleted' => fake()->boolean(),
            'airline_id' => random_int(1,30),
            'origin' => random_int(1,30),
            'destination' => random_int(1,30),
            'type' => fake()->randomElement(['Systemic','Charter']),
            'cabinclass' => fake()->randomElement(['Firstclass','Business','Economy'])
        ];
    }
}
