<?php

namespace Database\Factories\Items;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Items\UserItem>
 */
class UserItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->numberBetween(1, 100),
            'used_amount' => fake()->numberBetween(1, 100),
            'sold_amount' => fake()->numberBetween(1, 100),
        ];
    }
}
