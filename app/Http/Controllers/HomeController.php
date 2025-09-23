<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $products = Product::all();
        $categories = ProductCategory::all();

        $viewData = [];
        $viewData['products'] = $products;
        $viewData['categories'] = $categories;

        return view('home.index')->with('viewData', $viewData);
    }
}
