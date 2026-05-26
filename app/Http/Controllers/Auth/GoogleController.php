<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name'              => $googleUser->getName(),
                    'google_id'         => $googleUser->getId(),
                    'password'          => bcrypt(str()->random(24)),
                    'is_admin'          => false,
                ]
            );

            Auth::login($user, true);

            if ($user->is_admin) {
                return redirect('/admin');
            }

            return redirect('/');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Login Google gagal. Silakan coba lagi.');
        }
    }
}
