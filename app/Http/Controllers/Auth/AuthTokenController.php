<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Active_code;
use App\Models\User;
use Illuminate\Http\Request;

class AuthTokenController extends Controller
{
    public function getToken(Request $request)
    {
        if (!$request->session()->has('auth')) {
            return redirect('/login');
        }
        $request->session()->reflash();

        return view('auth.phoneVerify');
    }

    public function postToken(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        if (!$request->session()->has('auth')) {
            return redirect('/login');
        }

        $user = User::findOrFail($request->session()->get('auth.user_id'));
        
        $status = Active_code::verifyCode($request->token, $user);

        if(!$status) {
            alert()->error('کد صحیح نبود','خطا');
            return redirect('/login');
        }

        if(auth()->loginUsingId($user->id, $request->session()->get('auth.remmeber'))) {
            $user->activecode()->delete();

            return redirect(route('home'));
        }

        return redirect('/login');
    }
}
