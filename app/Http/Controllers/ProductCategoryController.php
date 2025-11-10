<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Contracts\View\View;

class ProductCategoryController extends Controller
{
    public function show(int $categoryId): View
    {
        $category = ProductCategory::findOrFail($categoryId);
        $products = $category->products()->paginate(20);

        $viewData = [];
        $viewData['category'] = $category;
        $viewData['products'] = $products;
        $viewData['breadcrumbs'] = [
            ['label' => __('Products'), 'url' => route('products.index')],
            ['label' => $category->getName(), 'url' => '#'],
        ];

        return view('product-categories.show')->with('viewData', $viewData);
    }
}
