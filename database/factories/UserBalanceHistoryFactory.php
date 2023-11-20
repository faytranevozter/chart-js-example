<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserBalanceHistory>
 */
class UserBalanceHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $d = now()->setMonth(rand(1, 12))->subSeconds(rand(1, 3599));

        return [
            'type' => ['in', 'out'][rand(0,1)],
            'amount' => rand(10000, 9999999),
            'created_at' => $d,
            'updated_at' => $d,
        ];
    }
}
