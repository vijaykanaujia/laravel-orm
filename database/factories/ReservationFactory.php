<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'check_in' => fake()->dateTimeBetween('-10 days', 'now'),
            'check_out' => fake()->dateTimeBetween('now', '+10 days'),
            'user_id' => fake()->numberBetween(1, 3),
            'room_id' => fake()->numberBetween(1, 10),
            'city_id' => fake()->numberBetween(1, 2),
        ];
    }
}
