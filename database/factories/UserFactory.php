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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'nomor_induk_kader' => fake()->boolean(70) ? 'HMI-' . fake()->unique()->randomNumber(6) : null,
            'role' => fake()->randomElement(['administrator', 'pengurus', 'kader']),
            'status' => fake()->randomElement(['pending', 'verified', 'inactive']),
            'phone' => fake()->phoneNumber(),
            'birth_date' => fake()->date('Y-m-d', '-18 years'),
            'address' => fake()->address(),
            'angkatan' => fake()->year('now'),
            'fakultas' => fake()->randomElement(['Hukum', 'Ekonomi', 'FISIP', 'Teknik', 'Kedokteran']),
            'jurusan' => fake()->randomElement(['Ilmu Hukum', 'Ekonomi Pembangunan', 'Ilmu Politik', 'Teknik Informatika']),
            'profile_completed' => fake()->boolean(80),
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

    /**
     * Indicate that the user is an administrator.
     */
    public function administrator(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'administrator',
            'status' => 'verified',
            'nomor_induk_kader' => 'HMI-ADM-' . fake()->unique()->randomNumber(3),
            'profile_completed' => true,
        ]);
    }

    /**
     * Indicate that the user is a pengurus.
     */
    public function pengurus(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'pengurus',
            'status' => 'verified',
            'nomor_induk_kader' => 'HMI-PNG-' . fake()->unique()->randomNumber(3),
            'profile_completed' => true,
        ]);
    }

    /**
     * Indicate that the user is a kader.
     */
    public function kader(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'kader',
            'status' => fake()->randomElement(['pending', 'verified']),
            'nomor_induk_kader' => fake()->boolean(60) ? 'HMI-KDR-' . fake()->unique()->randomNumber(3) : null,
        ]);
    }

    /**
     * Indicate that the user is verified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'verified',
            'nomor_induk_kader' => 'HMI-' . strtoupper(substr($attributes['role'] ?? 'KDR', 0, 3)) . '-' . fake()->unique()->randomNumber(3),
        ]);
    }

    /**
     * Indicate that the profile is completed.
     */
    public function profileCompleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'profile_completed' => true,
            'phone' => fake()->phoneNumber(),
            'birth_date' => fake()->date('Y-m-d', '-18 years'),
            'address' => fake()->address(),
            'angkatan' => fake()->year('now'),
            'fakultas' => 'Hukum',
            'jurusan' => 'Ilmu Hukum',
        ]);
    }
}