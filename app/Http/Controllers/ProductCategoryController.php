<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Contracts\View\View;
use Throwable;

class ProductCategoryController extends Controller
{
    public function show(int $categoryId): View
    {
        try {
            $category = ProductCategory::findOrFail($categoryId);
            $products = $category->products()->paginate(20);

            $viewData = [];
            $viewData['category'] = $category;
            $viewData['products'] = $products;

            return view('product-category.show')->with('viewData', $viewData);
        } catch (Throwable $th) {
            return abort(404);
        }
    }
}
