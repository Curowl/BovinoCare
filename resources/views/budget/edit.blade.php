@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
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
                    <form action="/budget/{{$budget->uuid}}" method="POST" class="needs-validation" novalidate>
                        @method('PUT')
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="budgetTitle" class="form-label">Title</label>
                                <input type="text" class="form-control  @error('title') is-invalid @enderror" id="budgetTitle" name="title" placeholder="I want to make party with friends next month ..." required value="{{$budget->title}}">
                                @error('title')
                                    <div class="invalid-feedback">
                                        Please fill the title
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="budgetDescription" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="budgetDescription" name="description" rows="3" placeholder="Tell the description about it" required>{{$budget->description}}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        Please fill the description
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="amount" class="form-label">Maximum amount</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" disabled id="amount" value="{{$budget->maximum_amount}}">
                            </div>
                        </div>
                        <div class="row mb-3 g-3">
                            <div class="col">
                              <label for="category" class="form-label">Choose category (optional)</label>
                              <select class="form-select" id="category" name="category[]" multiple data-allow-clear="true">
                                    @if(count($category) > 0)
                                        @foreach($category as $key => $cat)
                                            @foreach($budget->category as $bud)
                                                @if ($cat->uuid == $bud->uuid)
                                                    <option selected disabled hidden value="">Choose a tag...</option>
                                                    <option value="{{$cat->uuid}}" selected>{{$cat->name}}</option>
                                                @endif
                                            @endforeach
                                            <option selected disabled hidden value="">Choose a tag...</option>
                                            <option value="{{$cat->uuid}}">{{$cat->name}}</option>
                                        @endforeach
                                    @endif
                              </select>
                              <div class="invalid-feedback">Please select a valid tag.</div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                <label class="form-label">Money / Budgeting history</label>
                                <div id="money-container">

                                    {{-- <div class="row mb-2">
                                        <div class="col d-flex">
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" class="form-control" name="budgetHistory[]">
                                            </div>
                                            <button class="btn btn-outline-danger btn-sm ms-3 remove-money">X</button>
                                        </div>
                                    </div> --}}

                                </div>
                            </div>
                        </div>
                        @error('budgetHistory')
                            <div class="row">
                                <div class="col">
                                    <span style="color: red">{{$errors->first()}}</span>
                                </div>
                            </div>
                        @enderror
                        <div class="row">
                            <div class="col text-center">
                                <button class="btn btn-outline-success btn-sm" id="add-more-money" @error('budgetHistory') disabled @enderror>Add budget</button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <button type="submit" id="submit" class="btn btn-outline-primary">Save</button>
                                <a href="/budget/{{$budget->uuid}}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
        </div>
    </div>
</div>
@endsection
