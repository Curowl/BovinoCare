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
                    <form action="/budget" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="budgetTitle" class="form-label">Title</label>
                                <input type="text" class="form-control  @error('title') is-invalid @enderror" id="budgetTitle" name="title" placeholder="I want to make party with friends next month ..." required>
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
                                <textarea class="form-control @error('description') is-invalid @enderror" id="budgetDescription" name="description" rows="3" placeholder="Tell the description about it" required></textarea>
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
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input type="number" class="form-control  @error('amount') is-invalid @enderror" id="amount" name="amount" required>
                                @error('amount')
                                    <div class="invalid-feedback">
                                        Please fill maximum amount of money
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                              <label for="category" class="form-label">Choose category (optional)</label>
                              <select class="form-select" id="category" name="category[]" multiple data-allow-clear="true">
                                    @foreach($category as $key => $cat)
                                        <option selected disabled hidden value="">Choose a tag...</option>
                                        <option value="{{$cat->uuid}}">{{$cat->name}}</option>
                                    @endforeach
                              </select>
                              <div class="invalid-feedback">Please select a valid tag.</div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                <label for="first-money" class="form-label">Add first money for this budget</label>
                                <input type="number" class="form-control @error('firstMoney') is-invalid @enderror" id="first-money" name="firstMoney">
                                <div style="color: red; display:none" class="invalid-feedback">Cannot larger than maximum amount</div>
                                @error('firstMoney')
                                    <div class="invalid-feedback">
                                        {{$errors->first()}}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-outline-primary">Save</button>
                                <a href="/budget" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
        </div>
    </div>
</div>
@endsection
