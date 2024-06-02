<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'date_of_birth' => $this->faker->date(),
            'exp' => $this->faker->numberBetween(1,1000),
            'coins' => $this->faker->numberBetween(1,1000),
            'cover_photo' => $this->faker->randomElement(['coverphoto/cPNXMu5NCANZQ0U9ZeUcnhiwVhYpWGMmGvMXr2fj.jpg', 'coverphoto/JLfqAeBbqMWuhDexd3LfXxoJuwqSvOCg8iojtQmT.png', 'coverphoto/OxBMdN2yT4k8ibNKaFWS2XywB260RFwLZWgk80Wf.jpg', 'coverphoto/PucG4R4V0J9rdfrgegaUWHHd7wLP477dBPkNTuzF.jpg', 'coverphoto/xgaVYZgRjZKLJmWZtMe6jZhQxEzNOxYkjMjgD7Pw.jpg', 'none']),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
