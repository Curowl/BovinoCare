<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Budgety>
 */
class BudgetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->sentence(),
            'maximum_amount' => 3700000.00, // 3.7 million 
            'created_by' => 1 // user id 1 (the first user in the users table). It's just for testing puspose, so its OK
        ];
    }
}
