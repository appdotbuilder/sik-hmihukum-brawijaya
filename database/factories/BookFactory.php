<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'description' => fake()->paragraph(),
            'type' => fake()->randomElement(['physical', 'digital']),
            'isbn' => fake()->isbn13(),
            'stock' => fake()->numberBetween(0, 10),
            'file_path' => fake()->boolean(30) ? 'books/' . fake()->slug() . '.pdf' : null,
            'cover_image' => fake()->boolean(50) ? 'covers/' . fake()->slug() . '.jpg' : null,
            'category' => fake()->randomElement(['textbook', 'reference', 'research', 'islamic', 'law', 'general']),
            'status' => fake()->randomElement(['available', 'maintenance', 'unavailable']),
        ];
    }

    /**
     * Indicate that the book is physical.
     */
    public function physical(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'physical',
            'file_path' => null,
            'stock' => fake()->numberBetween(1, 10),
        ]);
    }

    /**
     * Indicate that the book is digital.
     */
    public function digital(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'digital',
            'file_path' => 'books/' . fake()->slug() . '.pdf',
            'stock' => 0,
        ]);
    }

    /**
     * Indicate that the book is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'available',
        ]);
    }
}