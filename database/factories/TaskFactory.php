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
            'task_list_id' => \App\Models\TaskList::factory(),
            'text' => $this->faker->sentence,
            'labels' => $this->faker->words(3, true),
            'status' => $this->faker->randomElement(['pending', 'completed']),
            'priority' => $this->faker->boolean,
        ];
    }
}
