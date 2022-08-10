<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'gender' => rand(0, 1) ? 'male' : 'female',
            'date_of_birth' => $this->faker->date($format='Y-m-d', $max = 'now'),
            'contact_number' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
        ];
    }
}
