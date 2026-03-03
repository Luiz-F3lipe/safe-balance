<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionInstallments>
 */
class TransactionInstallmentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_id' => Transaction::factory(),
            'installment'    => $this->faker->numberBetween(1, 12),
            'amount'         => $this->faker->randomFloat(2, 1, 1000),
            'due_date'       => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
