<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => $this->faker->numberBetween(1, 10),
            "title" => $this->faker->title,
            "description" => $this->faker->text,
            "color" => $this->faker->hexColor,
            "starts_at" => $this->faker->dateTime(),
            "done_at" => $this->faker->dateTime(),
        ];
    }
}
