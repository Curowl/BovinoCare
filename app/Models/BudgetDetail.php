<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Exception;

class BudgetDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'budget';
    protected $table = 'budget_detail';

    protected static function boot(){
        parent::boot();

        static::creating(function ($model){
            try {
                $model->uuid = Str::random(20);
            } catch (Exception $e) {
                abort(500, $e->getMessage());
            }
        });
    }
    
    public function creator(){
        return $this->setConnection('mysql')->hasOne(User::class, 'id', 'created_by');
    }

    public function budget(){
        return $this->hasOne(Budget::class);
    }
}
