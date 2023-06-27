<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    @if(isset($javascript))
        @if($javascript =='category-read')
            @vite(['resources/js/category-read.js'])
        @endif
        @if($javascript =='budget-create')
            @vite(['resources/js/budget-create.js'])
        @endif
        @if($javascript =='budget-edit')
            @vite(['resources/js/budget-edit.js'])
        @endif
    @endif
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @auth
            <nav class="navbar navbar-expand-lg bg-primary-subtle">
                <div class="container">
                    <div class="col-10">
                        <a class="btn btn-sm btn-outline-primary me-2" style="line-height: 15px;" href="/budget">Budgeting</a>
                        <a class="btn btn-sm btn-outline-primary" style="line-height: 15px;" href="/category">Category</a>
                    </div>
                    <div class="col-2 text-end">
                        @if (isset($page))
                            @if ($page =='budget')
                                <button class="btn btn-sm btn-outline-primary " style="line-height: 15px;" data-bs-toggle="modal" data-bs-target="#budgetsFilter">Filter</button>
                            @elseif($page == 'category')
                                <button class="btn btn-sm btn-outline-primary " style="line-height: 15px;" data-bs-toggle="modal" data-bs-target="#categoryFilter">Filter</button>
                            @endif
                        @endif
                    </div>
                </div>
            </nav>
            <div class="modal fade" id="budgetsFilter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="budgetsFilterLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-4" id="budgetsFilterLabel">Budgets Filter</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/budget" method="GET">
                                <div class="mb-3">
                                    <label class="form-label">Budget amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Min</span>
                                        <input type="number" class="form-control" placeholder="250000" name="minimumAmount">
                                        <span class="input-group-text">Max</span>
                                        <input type="number" class="form-control" placeholder="530000" name="maximumAmount">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date Created</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="dateStart">
                                        <span class="input-group-text">to</span>
                                        <input type="date" class="form-control" name="dateEnd">
                                    </div>
                                </div>
                                <div class="mb-3 text-end">
                                    <button type="submit" class="btn btn-outline-primary">Apply</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="categoryFilter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="categoryFilterLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-4" id="categoryFilterLabel">Category Filter</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/category" method="GET">
                                <div class="mb-3">
                                    <label class="form-label">Sort by Alphabetic</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sortAlphabetic" id="asc" value="asc">
                                        <label class="form-check-label" for="asc">
                                          Asc
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sortAlphabetic" id="desc" value="desc" checked>
                                        <label class="form-check-label" for="desc">
                                          Desc
                                        </label>
                                      </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date Created</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="dateStart">
                                        <span class="input-group-text">to</span>
                                        <input type="date" class="form-control" name="dateEnd">
                                    </div>
                                </div>
                                <div class="mb-3 text-end">
                                    <button type="submit" class="btn btn-outline-primary">Apply</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endauth

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
