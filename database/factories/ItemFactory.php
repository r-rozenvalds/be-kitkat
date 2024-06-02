<?php

namespace Database\Factories;

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
    public function definition(): array
    {
        return [
            'title'=> $this->faker->word,
            'description' => $this->faker->sentence,
            'color' => $this->faker->randomElement(["red", "black", "yellow", "purple", "white"]),
            'price' => $this->faker->randomFloat(0,100,10000),
            'type' => $this->faker->randomElement(["clothing", "hat"]),
            'image' => "items/I60rJdGI0c8j56RAn6wJ3Vl7sxZswXUPVrsziJ2W.png",
        ];
    }
}
