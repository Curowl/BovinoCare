@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <p><a href="/budget{{$uri}}" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Back to budgets</a></p>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col text-center">
                            <span style='font-size:40px;'>&#127919;</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-center">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Budget</h1>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="row">
                            <div class="col">
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <p>{{ session('status') }}</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-9">
                            <h3>{{$budget->title}}</h3>
                        </div>
                        <div class="col-3 text-end">
                            <a href="/budget/{{$budget->uuid}}/edit{{$uri}}" class="btn btn-outline-primary">Update</a>
                            <a href="/budget/{{$budget->uuid}}/delete{{$uri}}" class="btn btn-sm btn-outline-danger">Delete</a>
                        </div>
                    </div>
                    <p>{{$budget->description}}</p>
                    <h6 class="card-text" style="color: green"><strong>Rp{{$budget->maximum_amount}}</strong></h6>
                    @if(count($budget->budgetDetail)> 0)
                        <p>Rp{{$budget->budgetDetail->sum('amount')}}</p>
                    @endif
                    <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar bg-success" style="width: 25%"></div>
                    </div>
                    <hr>
                    @if(count($budget->budgetDetail)> 0)
                        <h5>Budget history</h5>
                        <ul class="list-group mb-3">
                            @foreach($budget->budgetDetail as $bud)
                                <li class="list-group-item"><strong>Rp{{$bud->amount}}</strong><span> &nbsp;{{$bud->created_at}}</span></li>
                            @endforeach
                        </ul>
                    @endif
                    @if(count($budget->category) > 0)
                        <div class="row">
                            <div class="col">
                                <h5>Categories</h5>
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            @foreach($budget->category as $cat)
                                <div class="col">
                                <div class="card h-100">
                                    <a href="/category/{{$cat->uuid}}/detail" class="card-body" style="text-decoration: none">
                                        <h5 class="card-title">{{$cat->name}}</h5>
                                        <p class="card-text">{{substr($cat->description, 0, 50)}}</p>
                                    </a>
                                </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
              </div>
        </div>
    </div>
</div>
@endsection
