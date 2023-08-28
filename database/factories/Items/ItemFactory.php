<?php

namespace Database\Factories\Items;

use App\Models\Items\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company,
            'usable_amount' => fake()->numberBetween(1, 5),
        ];
    }
}
