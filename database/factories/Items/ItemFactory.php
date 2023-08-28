<?php

namespace Database\Factories\Items;

use App\Enums\BonusEnum;
use App\Models\Items\Item;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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
            'name' => Str::ucfirst(fake()->word()),
            'usable_amount' => fake()->numberBetween(1, 5),
            'tier' => fake()->numberBetween(1, 6),
            'power' => Arr::random([5, 10, 20, 25, 30, 40, 50]),
            'attributes' => $this->rollAttributes(),
        ];
    }

    /**
     * @throws Exception
     */
    private function rollAttributes(): array
    {
        $attributes = [];
        $possibleAttributes = BonusEnum::getValues();
        $attributesCount = fake()->numberBetween(1, 3);

        for ($i = 0; $i < $attributesCount; $i++) {
            $attribute = Arr::random($possibleAttributes);

            $attributes[] = [
                'name' => $attribute,
                'value' => Arr::random(BonusEnum::tryFrom($attribute)->possibleValues()),
            ];

            $key = array_search($attribute, $possibleAttributes, true);
            Arr::forget($possibleAttributes, $key);
        }

        return $attributes;
    }
}
