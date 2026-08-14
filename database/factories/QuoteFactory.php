<?php

namespace Database\Factories;

use App\Models\Quote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteFactory extends Factory
{
    protected $model = Quote::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'client_name' => fake()->name(),
            'client_email' => fake()->email(),
            'status' => 'draft',
            'total' => 0,
            'expires_at' => now()->addDays(30),
        ];
    }

    public function sent(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'sent',
        ]);
    }
}
