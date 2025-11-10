<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('google_id', $googleUser->getId())->first();

            if (! $user) {
                $nameParts = explode(' ', $googleUser->getName(), 2);
                $name = $nameParts[0];
                $lastname = $nameParts[1] ?? '';

                $user = User::updateOrCreate(
                    ['email' => $googleUser->getEmail()],
                    [
                        'name' => $name,
                        'lastname' => $lastname,
                        'google_id' => $googleUser->getId(),
                        'phone' => '0000000000',
                        'birthdate' => now()->subYears(18)->toDateString(),
                        'password' => bcrypt('random'.rand(100000, 999999)),
                    ]
                );
            }

            Auth::login($user);

            if ($user->isAdmin()) {
                return redirect()->route('admin.index');
            }

            return redirect()->route('home.index');
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Google login failed. Please try again.');
        }
    }
}
