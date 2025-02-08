<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\Transaction\Type;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => fake()->dateTimeBetween('now', '1year'),
            'price' => fake()->numberBetween(100, 10000),
            'quantity' => fake()->numberBetween(1, 100),
            'type' => Type::cases()[fake()->numberBetween(0, 1)],
        ];
    }
}
