<?php

namespace Database\Factories\Cosmetics;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cosmetics\Cosmetic>
 */
class CosmeticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'usable_amount' => fake()->numberBetween(1, 5),
        ];
    }
}
