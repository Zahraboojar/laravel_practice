<?php

namespace App\Traits;

use App\Models\Active_code;
use Illuminate\Http\Request;

trait TwoFactorAuthenticate
{
    public function loggedin(Request $request, $user)
    {
        if ($user->two_factor_type !== 'off') {
            auth()->logout();

            $request->session()->flash('auth',[
                'user_id' => $user->id,
                'using_sms' => false,
                'remember' => $request->has('remember')
            ]);

            if($user->two_factor_type === 'sms') {
                $code = Active_code::generateCode($user);

                $request->session()->push('auth.using_sms', true);

                return redirect(route('2fa.token'));
            }
        }

        return ;
    }
}