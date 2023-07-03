<?php

namespace Database\Factories\Market;

use App\Models\Items\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class MarketOfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'expires_at' => now()->addDays(7),
            'promoted' => false,
            'type' => 'sell',
            'at_price' => $this->faker->numberBetween(100, 1000),
            'lat_price' => $this->faker->numberBetween(100, 1000),
            'description' => $this->faker->text(100),
        ];
    }
}
