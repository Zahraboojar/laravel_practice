<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\TwoFactorAuthenticate;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use function Laravel\Prompts\alert;

class GoogleAuthController extends Controller
{
    use TwoFactorAuthenticate;
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $google_user = Socialite::driver('google')->user();
            $user = User::where('email', $google_user->email)->first();

            if(! $user) {
                $user = User::create([
                    'name' => $google_user->name,
                    'email' => $google_user->email,
                    'password' => bcrypt(\Str::random(16))
                ]);
            }
            if(! $user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
            }

            auth()->loginUsingId($user->id);
            
            return $this->loggedin($request, $user)?: redirect(route('home'));
        } catch (\Exception $e) {
            alert('ورود با گوگل موفق نبود');
            return redirect('/');
        }
    }
}
