<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        
        $products = \App\Models\Product::all();

        $viewData = [];
        $viewData['products'] = $products;

        return view('home.index')->with('viewData', $viewData);
    }
}
