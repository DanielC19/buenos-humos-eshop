<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\HealiumService;
use Illuminate\Contracts\View\View;

class AlliesController extends Controller
{
    public function index(): View
    {
        $healiumService = app(HealiumService::class);
        $suppliers = $healiumService->getSuppliers();

        $viewData = [];
        $viewData['suppliers'] = $suppliers;

        return view('allies.index')->with('viewData', $viewData);
    }
}
