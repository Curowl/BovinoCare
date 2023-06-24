<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use App\Models\Budget;
use App\Models\BudgetDetail;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BudgetyDetail>
 */
class BudgetDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $budget     = Arr::random(Budget::select('id', 'maximum_amount')->get()->toArray());

        return [
            'budget_id' => $budget['id'],
            'amount' => 285800, // its just for testing purpose, so if the sum amount more than maximum_amount its OK
            'created_by' => 1 // user id 1 (the first user in the users table). It's just for testing puspose, so its OK
        ];
    }
}
