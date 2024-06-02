<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
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
            'description' => $this->faker->text(120),
            'media' => $this->faker->randomElement(['media/4Ax1rxkEqi8Z5GiXbw57TXNljxBp5YbwYqBqX7Ut.webp', 'media/6Y8U1nrSIYbfYh0X0axZY7SYoy6mOXEgiKhvqcoa.webp', 'media/AVIMdWAkVDlrGY2jeeOlyeRyidty6pNYqUkaXHYN.webp', 'media/GhCrIDpFyeRaLMvWmeeVRdHdShJWfDmJyK6XnrLX.webp', 'media/kwK9htAFAVXLi0FmXniGvbqd5ZT1P0g8g29sOCQS.webp', 'media/o9ZJzfOSd4DXwvETEVQoBCtT2uvtSDKycOUHRzY5.webp', 'media/y3cHerfsc9OELsDBh40yJOJnVr9D2zg38YPMAb2E.webp', 'media/Zh6WUawwlzPorQbaRBkwU9Z8hoYPA5pjLaO1EaMf.webp']),
            
        ];
    }
}
