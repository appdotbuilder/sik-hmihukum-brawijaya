<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->dateTimeBetween('-1 month', '+2 months');
        $startTime = fake()->time('H:i:s');
        $endTime = fake()->time('H:i:s');

        return [
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'location' => fake()->address(),
            'participant_type' => fake()->randomElement(['all_kader', 'pengurus', 'selected']),
            'status' => fake()->randomElement(['planned', 'ongoing', 'completed', 'cancelled']),
            'created_by' => User::factory(),
        ];
    }

    /**
     * Indicate that the activity is upcoming.
     */
    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'date' => fake()->dateTimeBetween('now', '+2 months'),
            'status' => fake()->randomElement(['planned', 'ongoing']),
        ]);
    }

    /**
     * Indicate that the activity is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'date' => fake()->dateTimeBetween('-2 months', 'now'),
            'status' => 'completed',
        ]);
    }
}