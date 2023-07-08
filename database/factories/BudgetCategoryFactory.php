<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use App\Models\Category;
use App\Models\Budget;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BudgetyCategory>
 */
class BudgetCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $budget_id =  Arr::random(Budget::select('id')->get()->toArray());
        $category_id =  Arr::random(Category::select('id')->get()->toArray());
        // dd($budget_id['id'], $category_id['id']);
        return [
            'budget_id' => $budget_id['id'],
            'category_id' => $category_id['id'], 
            'created_by' => 1 // user id 1 (the first user in the users table). It's just for testing puspose, so its OK
        ];
    }
}
