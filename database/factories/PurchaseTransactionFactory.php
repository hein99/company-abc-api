<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseTransaction>
 */
class PurchaseTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $total_spent = $this->faker->randomFloat($nbMaxDecimals = 2, $min = 25, $max = 999);
        $total_saving = $this->faker->randomFloat($nbMaxDecimals = 2, $min = 5, $max = $total_spent);
        return [
            'customer_id' => Customer::factory(),
            'total_spent' => $total_spent, 
            'total_saving' => $total_saving,
        ];
    }
}
