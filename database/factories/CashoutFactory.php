<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cashout>
 */
class CashoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'amount' => $this->faker->numberBetween(100, 1000),
            'user_id' => User::inRandomOrder()->first()->id,
            'request_date' => now(),
            'status' => $this->faker->numberBetween(0, 2),
            'approved_date' => now()->addDays(5),
            'release_date' => now()->addDays(6),
            'received_Date' => now()->addDays(6)
        ];
    }
}
