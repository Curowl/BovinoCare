<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Exception;

class Budget extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'budget';
    protected $table = 'budgets';

    protected static function boot(){
        parent::boot();

        static::creating(function ($model){
            try {
                $model->uuid = Str::slug($model->title, '-').'-'.Str::random(10);
            } catch (Exception $e) {
                abort(500, $e->getMessage());
            }
        });
    }
    
    public function creator(){
        return $this->setConnection('mysql')->hasOne(User::class, 'id', 'created_by');
    }

    public function category(){
        return $this->belongsToMany(Category::class);
    }

    public function budgetDetail(){
        return $this->hasMany(BudgetDetail::class);
    }
}
