<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Budget;
use App\Models\BudgetCategory;
use App\Models\BudgetDetail;
use Carbon\Carbon;
use Database\Factories\BudgetFactory;

class BudgetController extends Controller
{
    public function index(Request $request){
        $data['page'] = 'budget';
        $data['budgets'] = Budget::with(['budgetDetail:budget_id,amount'])
                        ->where('created_by', auth()->user()->id)
                        
                        // filter amount
                        ->where(function($query) use($request){
                            if($request->query('minimumAmount') && $request->query('maximumAmount')){
                                $query->whereBetween('maximum_amount', [$request->query('minimumAmount'), $request->query('maximumAmount')]);
                            }
                            if($request->query('minimumAmount') && !$request->query('maximumAmount')){
                                $query->where('maximum_amount', '>', $request->query('minimumAmount'));
                            }
                            if(!$request->query('minimumAmount') && $request->query('maximumAmount')){
                                $query->where('maximum_amount', '<', $request->query('maximumAmount'));
                            }
                        })

                        // filter date created
                        ->where(function($query) use($request){
                            if($request->query('dateStart') && $request->query('dateEnd')){
                                $query->whereBetween('created_at', [$request->query('dateStart'), $request->query('dateEnd')]);
                            }
                            if($request->query('dateStart') && !$request->query('dateEnd')){
                                $query->where('created_at', '>', $request->query('dateStart'));
                            }
                            if(!$request->query('dateStart') && $request->query('dateEnd')){
                                $query->where('created_at', '<', $request->query('dateEnd'));
                            }
                        })
                        ->orderBy('created_at', 'desc')
                        ->select('id', 'uuid', 'title', 'description', 'maximum_amount', 'created_at')
                        ->paginate(12)
                        ->withQueryString();
        $data['minimumAmount'] = $request->query('minimumAmount');
        $data['maximumAmount'] = $request->query('maximumAmount');
        $data['dateStart'] = $request->query('dateStart');
        $data['dateEnd'] = $request->query('dateEnd');
        $data['uri']= substr($request->getRequestUri(), 7); // remove /budget
        return view('budget.index',$data);
    }

    public function create(){
        $data['category'] = Category::where('created_by', auth()->user()->id)
                            ->select('uuid', 'name')
                            ->get();
        $data['javascript'] = 'budget-create';
        return view('budget.create', $data);
    }

    public function save(Request $request){
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'amount' => 'required'
        ]);
        $amount     = (int) $request->amount;
        $firstMoney = (int) $request->firstMoney;
        if($firstMoney > $amount){
            return back()->withErrors(['firstMoney' => 'Cannot larger than maximum amount']);
        }

        $budget = new Budget;
        $budget->title = $request->title;
        $budget->description = $request->description;
        $budget->maximum_amount = $request->amount;
        $budget->created_by = auth()->user()->id;
        $budget->saveOrFail();

        if($request->category && count($request->category) > 0){
            foreach($request->category as $cate){
                $budgetCategory = new BudgetCategory;
                $category = Category::select('id', 'uuid')->where('uuid', $cate)->first()->id;
                $budgetCategory->budget_id =  $budget->id;
                $budgetCategory->category_id = $category;
                $budgetCategory->created_by = auth()->user()->id;
                $budgetCategory->saveOrFail();
            }
        }

        $budgetDetail = new BudgetDetail();
        $budgetDetail->budget_id = $budget->id;
        $budgetDetail->amount = $request->firstMoney;
        $budgetDetail->created_by = auth()->user()->id;
        $budgetDetail->saveOrFail();

        return redirect('budget')->with('status', 'Success, new budget created! '.Carbon::now()->format('d/m/Y H:i'));
    }

    public function show(Request $request, $uuid){
        $data['budget'] = Budget::with(['category:id,uuid,name,description', 'budgetDetail:budget_id,uuid,amount,created_at'])
                                ->where('uuid', $uuid)
                                ->where('created_by', auth()->user()->id)
                                ->select('id', 'uuid', 'title', 'description', 'maximum_amount', 'created_at')
                                ->first();
        
        $data['uri'] = str_replace('/budget'.'/'.$uuid, '', $request->getRequestUri());
        return view('budget.detail', $data);
    }

    public function showHistory($uuid){
        $data['budget'] = Budget::with(['category:id,uuid,name,description', 'budgetDetail:budget_id,uuid,amount,created_at'])
                                ->where('uuid', $uuid)
                                ->where('created_by', auth()->user()->id)
                                ->select('id', 'uuid', 'title', 'description', 'maximum_amount', 'created_at')
                                ->first();
        return json_encode($data);
    }

    public function edit(Request $request, $uuid){
        $data['budget'] = Budget::with(['category:id,uuid,name,description', 'budgetDetail:budget_id,uuid,amount,created_at'])
                                ->where('uuid', $uuid)
                                ->where('created_by', auth()->user()->id)
                                ->select('id', 'uuid', 'title', 'description', 'maximum_amount', 'created_at')
                                ->first();
        $data['category'] = Category::select('id', 'uuid', 'name')
                            ->where('created_by', auth()->user()->id)
                            ->get();
        $data['javascript'] = 'budget-edit';
        $data['uri'] = str_replace('/budget'.'/'.$uuid.'/edit', '', $request->getRequestUri());
        return view('budget.edit', $data);
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $budget = Budget::with('category:uuid', 'budgetDetail:id,budget_id,amount')
                        ->select('id', 'uuid', 'title', 'description', 'maximum_amount')
                        ->where('uuid', $uuid)
                        ->where('created_by', auth()->user()->id)
                        ->first();
        if($request->budgetHistory){
            $budgetHistory = (int) $request->budgetHistory[0];
            if($budgetHistory > $budget->maximum_amount){
                return back()->withErrors(['budgetHistory' => 'Cannot larger than maximum amount. Refresh the page to remove warning and then resubmit']);
            }else{
                $budgetDetail = new BudgetDetail();
                $budgetDetail->budget_id = $budget->id;
                $budgetDetail->amount = $request->budgetHistory[0];
                $budgetDetail->created_by = auth()->user()->id;
                $budgetDetail->saveOrFail();
            }
        }

        $budget->title = $request->title;
        $budget->description = $request->description;
        $budget->saveOrFail();

        if(count($request->category) > 0){
            
            BudgetCategory::whereIn('budget_id',[$budget->id])->delete();

            foreach($request->category as $cate){
                $categoryId = Category::select('id')->where('uuid', $cate)->first()->id;
                $budgetCategory = new BudgetCategory();
                $budgetCategory->budget_id =  $budget->id;
                $budgetCategory->category_id = $categoryId;
                $budgetCategory->created_by = auth()->user()->id;
                $budgetCategory->saveOrFail();
            }
        }
    
        return redirect('budget/'.$budget->uuid)
                    ->with('status', 'Success, budget updated! '.Carbon::now()->format('d/m/Y H:i'));
    }

    public function delete(Request $request, $uuid){

        $data['budget'] = Budget::with(['category:id,uuid,name,description', 'budgetDetail:budget_id,uuid,amount,created_at'])
                                ->where('uuid', $uuid)
                                ->where('created_by', auth()->user()->id)
                                ->select('id', 'uuid', 'title', 'description', 'maximum_amount', 'created_at')
                                ->first();
        $data['uri'] = str_replace('/budget'.'/'.$uuid.'/delete', '', $request->getRequestUri());
        return view('budget.delete',$data);
    }

    public function destroy(Request $request, $uuid){
        $budget = Budget::where('uuid', $uuid)->first();
        $budget->deleted_by = auth()->user()->id;
        $budget->deleted_at = Carbon::now();
        $budget->updateOrFail();
        return redirect('budget')->with('status', 'Success, budget deleted! '.Carbon::now()->format('d/m/Y H:i'));
    }
}