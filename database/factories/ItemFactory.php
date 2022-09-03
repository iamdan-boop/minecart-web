<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'buyer_name' => $this->faker->name(),
            'type' => $this->faker->numberBetween(0, 1),
            'price' => $this->faker->numberBetween(100, 1000),
            'note' => $this->faker->randomAscii(),
            'status' => $this->faker->numberBetween(0, 3),
            'user_id' => User::inRandomOrder()->first()->id,
            'drop_date' => now()
        ];
    }
}
