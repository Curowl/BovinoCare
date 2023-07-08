<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['javascript'] = 'report';
        $data['category']   = Category::select('uuid', 'name')->get();
        return view('home', $data);
    }
}
