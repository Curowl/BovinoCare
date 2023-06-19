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
                    <form action="/category" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="categoryName" class="form-label">Name</label>
                                <input type="text" class="form-control  @error('name') is-invalid @enderror" id="categoryName" name="name" placeholder="Food, Entertainment, Traveling, etc..." required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        Please fill the name
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="categoryDescription" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="categoryDescription" name="description" rows="3" placeholder="Tell the description about it" required></textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        Please fill the description
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-outline-primary">Save</button>
                                <a href="/category" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
        </div>
    </div>
</div>
@endsection
