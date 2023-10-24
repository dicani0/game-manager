<?php

namespace Database\Factories\Character;

use App\Enums\VocationEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharacterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'vocation' => fake()->randomElement(VocationEnum::getValues()),
        ];
    }
}
