<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;

class BudgetCategory extends Model
{
    use HasFactory;

    protected $connection = 'budget';
    protected $table = 'budget_category';
}
