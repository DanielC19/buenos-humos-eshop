<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    /**
     * Switch the application locale
     */
    public function switch(string $locale): RedirectResponse
    {
        if (in_array($locale, ['en', 'es'])) {
            session(['locale' => $locale]);
        }

        return redirect()->back();
    }
}
