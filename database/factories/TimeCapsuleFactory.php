<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimeCapsule>
 */
class TimeCapsuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true),
            'reveal_date' => $this->faker->dateTime(),
            'is_revealed' => $this->faker->boolean(),
            'color' => $this->faker->randomElement(['blue', 'magenta', 'yellow', 'gray']),
            'location' => $this->faker->city() . ', ' . $this->faker->country(),
            'is_surprise_mode' => $this->faker->boolean(),
            'visibility' => $this->faker->randomElement(['public', 'unlisted', 'private']),
            'content_type' => 'text',
            'content_text' => $this->faker->text(),
            'content_voice_url' => null,
            'content_image_url' => null,
        ];
    }
}
