@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-sm-12 col-lg-6">
            <h4>Last 10 budget reach 100%</h4>
            <span>the last 10 budget which reach 100% of maximum amount in last 360 days</span>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2" id="last-10-budget-reach-100">
               
                {{-- <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-text">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Facere sed animi ut tenetur</h6>
                        </div>
                        <a href="" class="btn card-footer">
                            see detail
                        </a>
                    </div>
                </div> --}}
                

            </div>
        </div>
        <div class="col-sm-12 col-lg-6">
            <h4>Last 10 budget reach 50%</h4>
            <span>the last 10 budgets which reached 50% of the maximum amount in last 360 days</span>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2" id="last-10-budget-reach-50">
              
            </div>
        </div>
        <div class="col-sm-12 col-lg-6">
            <h4>Most choosen category</h4>
            <span>the most picked category in last 360 days</span>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2" id="most-choosen-category">
                
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-12 col-lg-6">
            <h4>Compare category</h4>
            <span>select to compare each total amount per month</span>
            <div id="categoriesContainer" class="mb-1">
                {{-- <div>
                    <select class="form-select" multiple data-allow-clear="true">
                          @if(count($category) > 0)
                                @foreach($category as $cat)
                                    <option selected disabled hidden value="">Choose a tag...</option>
                                    <option value="{{$cat->uuid}}">{{$cat->name}}</option>
                                @endforeach
                          @endif
                    </select>
                    <div class="invalid-feedback">Please select a valid tag.</div>
                </div> --}}
            </div>
            <div class="mb-3">
                <label class="form-label">Date Range</label>
                <div class="input-group">
                    <input type="date" class="form-control" id="dateStartCompare">
                    <span class="input-group-text">to</span>
                    <input type="date" class="form-control" id="dateEndCompare" >
                </div>
            </div>
            <button class="btn btn-outline-primary" id="filterCategory">Go</button>
        </div>
    </div>
    <div class="row">
        <div class="col" id="canvasReportContainer">
            <canvas id="acquisitions"></canvas>
        </div>
    </div>
</div>
@endsection
