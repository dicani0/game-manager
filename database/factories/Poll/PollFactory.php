<?php

namespace Database\Factories\Poll;

use App\Models\Poll\Poll;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Poll>
 */
class PollFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'start_date' => $this->faker->dateTime,
            'end_date' => $this->faker->dateTime,
            'status' => $this->faker->randomElement(['draft', 'published']),
        ];
    }
}
