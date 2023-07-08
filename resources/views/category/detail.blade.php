@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col text-center">
                            <span style='font-size:40px;'>&#127881;</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-center">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Category</h1>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="categoryName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="categoryName" name="name" value="{{$category->name}}" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="categoryDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="categoryDescription" name="description" rows="3" disabled>{{$category->description}}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="categoryDescription" class="form-label">Created at</label>
                            <input type="text" class="form-control" id="categoryName" name="name" value="{{$category->created_at}}" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="categoryDescription" class="form-label">Updated at</label>
                            <input type="text" class="form-control" id="categoryName" name="name" value="{{$category->updated_a}}" disabled>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($category->budget) > 0)
                        <div class="row">
                            <div class="col">
                                <h5>Budgets</h5>
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            @php
                                $totalAmountHistory = 0;
                            @endphp
                            @foreach($category->budget as $bud)
                                <div class="col">
                                    <div class="card h-100">
                                        <a href="/budget/{{$bud->uuid}}" class="card-body" style="text-decoration: none;">
                                            <h5 class="card-title">{{substr($bud->title, 0, 20)}}</h5>
                                            <p class="card-title">{{substr($bud->description, 0, 50)}}</p>
                                            <p class="card-title">Total history : Rp{{$bud->budgetDetail->sum('amount')}}</p>
                                            @php
                                                $totalAmountHistory += $bud->budgetDetail->sum('amount');
                                            @endphp
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <h5>Total amount history of this category</h5>
                                <p>Rp {{$totalAmountHistory}}</p>
                            </div>
                        </div>
                    @endif
                </div>
              </div>
        </div>
    </div>
</div>
@endsection
