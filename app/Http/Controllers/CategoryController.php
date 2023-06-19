<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;

class CategoryController extends Controller
{
    public function index(){
        $data['categories'] = Category::where('created_by', auth()->user()->id)
                        ->orderBy('created_at', 'desc')
                        ->select('uuid', 'name', 'description', 'created_at')
                        ->paginate(18);
        return view('category.index',$data);
    }

    public function create(){
        return view('category.create');
    }

    public function save(Request $request){
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->created_by = auth()->user()->id;
        $category->saveOrFail();

        return redirect('category');
    }

    public function show($uuid){
        $category = Category::where('uuid', $uuid)
                        ->select('uuid', 'name', 'description', 'created_at', 'updated_at')
                        ->first();
        return json_encode($category);
    }

    public function edit(Request $request, $uuid){
        $data['category'] = Category::where('uuid', $uuid)
                            ->select('uuid', 'name', 'description', 'created_at')
                            ->first();
       $data['paginationPage']= $request->query('page');
        return view('category.edit',$data);
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        $category = Category::where('uuid', $uuid)->first();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->updateOrFail();

        return redirect('category?page='.$request->query('page'))
                    ->with('status', 'Success, cateogry updated! '.Carbon::now()->format('d/m/Y H:i'));
                
    }

    public function delete(Request $request, $uuid){
        $data['category'] = Category::where('uuid', $uuid)
                        ->select('uuid', 'name', 'description', 'created_at')
                        ->first();
        $data['paginationPage']= $request->query('page');
        return view('category.delete',$data);
    }

    public function destroy(Request $request, $uuid){
        $category = Category::where('uuid', $uuid)->first();
        $category->deleted_by = auth()->user()->id;
        $category->deleted_at = Carbon::now();
        $category->updateOrFail();
        return redirect('category?page='.$request->query('page'))
                    ->with('status', 'Success, cateogry deleted! '.Carbon::now()->format('d/m/Y H:i'));
    }
}
