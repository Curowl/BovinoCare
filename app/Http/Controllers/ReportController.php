<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    private function getCategoryWithBudget(){
        $db = config('database.connections.budget.database');
        $category = DB::select('select c.id, c.uuid, c.name, c.deleted_at, b.budget_id, b.category_id, bs.id, bs.deleted_at, count(b.category_id) as budgetCount from '.$db.'.categories'.' AS c 
                        LEFT JOIN '.$db.'.budget_category'.' AS b ON b.category_id = c.id
                        LEFT JOIN '.$db.'.budgets'.' AS bs ON bs.id = b.budget_id
                        WHERE c.deleted_at is null
                        AND bs.deleted_at is null
                        GROUP BY c.id
                        ORDER BY budgetCount desc');
        return $category;
    }

    private function getBudgetWithDetail(){
        $budget = Budget::withWhereHas('budgetDetail')
                        ->where('created_by', auth()->user()->id)
                        ->select('id', 'uuid', 'title', 'maximum_amount')
                        ->whereBetween('created_at', [Carbon::now()->subDays(360), Carbon::now()])
                        ->orderBy('created_at', 'desc')
                        ->get();
        return $budget;
    }

    public function last10BudgetReach100(){
        $budget = $this->getBudgetWithDetail();
        $data['budget'] = [];
        foreach($budget as $bud){
            if($bud->budgetDetail->sum('amount') >= $bud->maximum_amount){
                if(count($data['budget']) < 10){
                    $data['budget'][] = $bud;
                }
            }
        }
        return json_encode($data);
    }

    public function last10BudgetReach50(){
        $budget = $this->getBudgetWithDetail();
        $data['budget'] = [];
        foreach($budget as $bud){
            if($bud->budgetDetail->sum('amount') > $bud->maximum_amount / 2){
                if(count($data['budget']) < 10){
                    $data['budget'][] = $bud;
                }
            }
        }
        return json_encode($data);
    }

    public function mostChoosenCategory(){
        $category = $this->getCategoryWithBudget();
        $data['category'] = [];
        foreach($category as $cate){
            if(count($data['category']) < 10){
                $data['category'][] = $cate;
            }
        }
        return json_encode($data);
    }

    public function compareCategory(Request $request){
        $uuids      = $request->query('categoryUuids');
        $dateStart  = $request->query('dateStart');
        $dateEnd    = $request->query('dateEnd');
        $with       = [
            'budget' => function($query) use($dateStart, $dateEnd){
                $query->select('id')
                    ->with('budgetDetail', function($query) use($dateStart, $dateEnd){
                            $query->select('created_at', 'amount', 'budget_id')
                                    ->whereBetween('created_at', [Carbon::createFromFormat('Y-m-d', $dateStart), Carbon::createFromFormat('Y-m-d', $dateEnd)]);
                        });
            }
        ];
        $category = Category::with($with)
                            ->where('created_by', auth()->user()->id)
                            ->whereIn('uuid', $uuids)
                            ->select('id', 'uuid', 'name', 'created_at')
                            ->get();
        $months = collect(CarbonPeriod::create($dateStart, '1 month', $dateEnd))->map(function($item, $key){
            return $item->format('Y-m');
        });
        $data['categories'] = [];
        foreach ($category as $cate) {
            $arrayMonth = [];
            foreach ($months as $mon) {
                $thisMonth = null;
                $totalBudget = 0;
                foreach ($cate->budget as $bud) {
                    foreach($bud->budgetDetail as $det){
                        if($mon === Carbon::parse($det->created_at)->format('Y-m')){
                            $totalBudget+= $det->amount;
                        }
                    }
                }
                $thisMonth = $totalBudget;
                $arrayMonth[$mon] = $thisMonth;
            }
            $data['categories'][$cate->name] = $arrayMonth;
        }
        // dd($months, $category->toArray());
        // dd(collect($category)->toArray());
        return json_encode($data);
    }
}