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
        // Obtener todos los productos
        $products = \App\Models\Product::all();
        // Si tienes un campo 'featured', puedes usar:
        // $products = \App\Models\Product::where('featured', true)->get();
        return view('home.index', compact('products'));
    }
}
