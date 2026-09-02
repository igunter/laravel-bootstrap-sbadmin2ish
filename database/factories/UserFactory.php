<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password = null;

    public function definition(): array
    {
        $days = rand(0, 50);
        $date = now()->subDays($days);

        return [
            'is_admin'          => false,
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => $date,
            'password'          => static::$password ??= bcrypt('P4$$w0rd!'),
            'remember_token'    => Str::random(10),
            'created_at'        => $date,
            'updated_at'        => $date,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
