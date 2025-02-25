<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $google_user = Socialite::driver('google')->user();
        $user = User::where('email', $google_user->email)->first();

        if($user) {
            auth()->loginUsingId($user->id);
        } else {
            $new_user = User::create([
                'name' => $google_user->name,
                'email' => $google_user->email,
                'password' => bcrypt(\Str::random(16))
            ]);

            auth()->loginUsingId($new_user->id);
        }
    }
}
