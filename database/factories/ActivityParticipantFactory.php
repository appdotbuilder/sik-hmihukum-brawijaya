<?php

namespace Database\Factories;

use App\Models\ActivityParticipant;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityParticipant>
 */
class ActivityParticipantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = ActivityParticipant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isPresent = fake()->boolean(70);
        
        return [
            'activity_id' => Activity::factory(),
            'user_id' => User::factory(),
            'is_present' => $isPresent,
            'attended_at' => $isPresent ? fake()->dateTimeThisMonth() : null,
            'notes' => fake()->boolean(20) ? fake()->sentence() : null,
        ];
    }

    /**
     * Indicate that the participant is present.
     */
    public function present(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_present' => true,
            'attended_at' => fake()->dateTimeThisMonth(),
        ]);
    }

    /**
     * Indicate that the participant is absent.
     */
    public function absent(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_present' => false,
            'attended_at' => null,
        ]);
    }
}