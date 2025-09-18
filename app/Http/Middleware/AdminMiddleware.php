<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): BaseResponse
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== UserRole::ADMIN) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        return $next($request);
    }
}
