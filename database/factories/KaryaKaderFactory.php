<?php

namespace Database\Factories;

use App\Models\KaryaKader;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KaryaKader>
 */
class KaryaKaderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = KaryaKader::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'type' => fake()->randomElement(['physical', 'digital']),
            'category' => fake()->randomElement(['research', 'article', 'thesis', 'proposal', 'islamic', 'law', 'general']),
            'file_path' => fake()->boolean(80) ? 'karya/' . fake()->slug() . '.pdf' : null,
            'cover_image' => fake()->boolean(30) ? 'covers/' . fake()->slug() . '.jpg' : null,
            'stock' => fake()->numberBetween(0, 5),
            'status' => fake()->randomElement(['available', 'review', 'unavailable']),
        ];
    }

    /**
     * Indicate that the karya is physical.
     */
    public function physical(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'physical',
            'stock' => fake()->numberBetween(1, 5),
        ]);
    }

    /**
     * Indicate that the karya is digital.
     */
    public function digital(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'digital',
            'file_path' => 'karya/' . fake()->slug() . '.pdf',
            'stock' => 0,
        ]);
    }

    /**
     * Indicate that the karya is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'available',
        ]);
    }
}