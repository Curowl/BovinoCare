@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(count($categories) > 0)
        <div class="row">
            <div class="col text-center">
                <span style='font-size:40px;'>&#127881;</span>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Categories</h1>
                <p>list of all categories</p>
                <a href="/category/create">Add new cetegory</a>
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
            @foreach($categories as $key => $cat)
            <div class="col">
                <div class="card h-100 category-card" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="cursor: pointer">
                    <div class="card-body">
                        <input type="hidden" value="{{$cat->uuid}}">
                        <h5 class="card-title">{{$cat->name}}</h5>
                        <p class="card-text">{{substr($cat->description, 0, 50)}}</p>
                    </div>
                </div>
            </div>
            @endforeach
          </div>
        @else
        <div class="col-md-8 text-center" style="height:100%;">
            <div style="position: absolute; margin: auto; top: 0; right: 0; bottom: 0; left: 0; width:200px; height: 200px;">
                <h4>Empty</h4>
                <p>You don't have category</p>
                <a class="btn btn-outline-primary" href="/category/create">Create</a>
            </div>
        </div>
        @endif
    </div>
    <br>
    {{ $categories->links() }}
</div>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-4" id="staticBackdropLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Modal body
        </div>
        <div class="modal-footer">
            <p>Created at </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <a type="button" href="" class="btn btn-outline-primary">Edit</a>
          <a type="button" href="" class="btn btn-outline-danger">Delete</a>
        </div>
      </div>
    </div>
  </div>
@endsection
