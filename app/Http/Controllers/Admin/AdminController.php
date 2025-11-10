<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['totalProducts'] = Product::count();
        $viewData['totalOrders'] = Order::count();
        $viewData['totalCustomers'] = User::customers()->count();
        $viewData['totalRevenue'] = Order::sum('total');

        return view('admin.index')->with('viewData', $viewData);
    }
}
