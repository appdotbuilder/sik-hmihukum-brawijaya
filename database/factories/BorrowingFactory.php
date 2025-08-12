<?php

namespace Database\Factories;

use App\Models\Borrowing;
use App\Models\User;
use App\Models\Book;
use App\Models\KaryaKader;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrowing>
 */
class BorrowingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Borrowing::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $borrowedAt = fake()->dateTimeBetween('-2 months', 'now');
        $dueDate = clone $borrowedAt;
        $dueDate->modify('+14 days');

        $borrowableType = fake()->randomElement([Book::class, KaryaKader::class]);
        $borrowableId = $borrowableType === Book::class 
            ? Book::factory()->create()->id 
            : KaryaKader::factory()->create()->id;

        return [
            'user_id' => User::factory(),
            'borrowable_type' => $borrowableType,
            'borrowable_id' => $borrowableId,
            'borrowed_at' => $borrowedAt,
            'due_date' => $dueDate,
            'returned_at' => fake()->boolean(60) ? fake()->dateTimeBetween($borrowedAt, 'now') : null,
            'status' => fake()->randomElement(['borrowed', 'returned', 'overdue', 'lost']),
            'notes' => fake()->boolean(30) ? fake()->sentence() : null,
        ];
    }

    /**
     * Indicate that the borrowing is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'borrowed',
            'returned_at' => null,
        ]);
    }

    /**
     * Indicate that the borrowing is returned.
     */
    public function returned(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'returned',
            'returned_at' => fake()->dateTimeBetween($attributes['borrowed_at'] ?? '-1 week', 'now'),
        ]);
    }

    /**
     * Indicate that the borrowing is overdue.
     */
    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'overdue',
            'due_date' => fake()->dateTimeBetween('-1 month', 'yesterday'),
            'returned_at' => null,
        ]);
    }
}