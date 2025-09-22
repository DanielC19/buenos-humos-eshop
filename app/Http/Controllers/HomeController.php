<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Product;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {

        $products = Product::all();

        $viewData = [];
        $viewData['products'] = $products;

        return view('home.index')->with('viewData', $viewData);
    }
}
