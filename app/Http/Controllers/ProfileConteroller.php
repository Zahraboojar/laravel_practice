<?php

namespace App\Http\Controllers;

use App\Models\Active_code;
use App\Notifications\ActiveCode;
use Illuminate\Http\Request;
use function Laravel\Prompts\alert;

class ProfileConteroller extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function two_factor_auth()
    {
        return view('profile.twofactorauth');
    }
    
    public function two_factor_auth_request(Request $request)
    {
        if ($data = $request->validate([
            'type' => 'required|in:sms,off',
            'phone' => 'required_unless:type,off|unique:users,phone_number'
        ])) {
            if ($data['type'] === 'sms') {
                if ($request->user()->phone !== $data['phone'] ) {
                    $code = Active_code::generateCode(auth()->user());

                    $request->session()->flash('phone', $data['phone']);

                    $request->user()->notify(new ActiveCode($code));

                    return redirect(route('phone_verify'));
                } else {
                    //
                }
                $request->user()->update([
                    'two_factor_type' => 'sms'
                ]);
            } elseif ($data['type'] === 'off'){
                $request->user()->update([
                    'two_factor_type' => 'off'
                ]);
                return redirect('/profile/twofactorauth');
            }
        } else {
            
        }
        
    }

    public function get_Phone_Verify(Request $request)
    {
        if (!$request->session()->has('phone')) {
            return redirect(route('two_factor_auth'));
        }

        $request->session()->reflash();

        return view('profile.phoneVerify');
    }

    public function post_Phone_Verify(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        if (!$request->session()->has('phone')) {
            return redirect(route('two_factor_auth'));
        }

        $status = Active_code::verifyCode($request->token, $request->user());

        if ($status) {
            $request->user()->activecode()->delete();
            $request->user()->update([
                'phone_number' => $request->session()->get('phone'),
                'two_factor_type' => 'sms'
            ]);

            alert('احراز هویت دو مرحله ای با موفقیت انجام شد');        
        } else {
            alert('عملیات ناموفق بود');
        }

        return redirect(route('two_factor_auth'));
    }
}
