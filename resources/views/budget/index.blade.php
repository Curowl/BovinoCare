@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(count($budgets) > 0)
        <div class="row">
            <div class="col text-center">
                <span style='font-size:40px;'>&#127919;</span>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Budgets</h1>
                <p>list of all budgets</p>
                <a href="/budget/create">Add new budget</a>
            </div>
        </div>
        @if (session('status'))
            <div class="row">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <p>{{ session('status') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-6 g-3">
            @foreach($budgets as $key => $bud)
                @php
                    $sum        = 0;
                    $valueNow   = 0;
                    $color      = 'red';
                    $bgColor    = 'bg-danger';
                    if(count($bud->budgetDetail) > 0){
                        $sum        = $bud->budgetDetail->sum('amount');
                        $valueNow   = ($sum / $bud->maximum_amount) * 100;
                        if($valueNow > 25 && $valueNow <= 50){
                            $color   = 'green';
                            $bgColor = 'bg-success';
                        }elseif($valueNow > 25 && $valueNow <= 100){
                            $color   = 'blue';
                            $bgColor = 'bg-primary';
                        }
                    }
                @endphp
                <div class="col">
                    <div class="card h-100 budget-card" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <div class="card-body">
                            <h6 class="card-text" style="color: {{$color}}"><strong>Rp{{$bud->maximum_amount}}</strong></h6>
                            <small>Rp{{$sum}}</small>
                            <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="{{$valueNow}}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar {{$bgColor}}" style="width: {{$valueNow}}%"></div>
                            </div>
                            <hr>
                            <h5 class="card-title">{{$bud->title}}</h5>
                            <p class="card-text">{{substr($bud->description, 0, 70)}}</p>
                        </div>
                        <a href="/budget/{{$bud->uuid}}{{$uri}}" class="card-footer btn bg-primary-subtle" style="cursor: pointer">See detail</a>
                    </div>
                </div>
            @endforeach
          </div>
        @else
        <div class="col-md-8 text-center" style="height:100%;">
            <div style="position: absolute; margin: auto; top: 0; right: 0; bottom: 0; left: 0; width:200px; height: 200px;">
                <h4>Empty</h4>
                <p>You don't have budget</p>
                <a class="btn btn-outline-primary" href="/budget/create">Create</a>
            </div>
        </div>
        @endif
    </div>
    <br>
    {{ $budgets->links() }}
</div>
@endsection
