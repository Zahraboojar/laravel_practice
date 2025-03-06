<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\VarDumper\VarDumper;

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
            'phone' => 'required_unless:type,off'
        ])) {
            if ($data['type'] === 'sms') {
                if ($request->user()->phone !== $data['phone'] ) {
                    $request->user()->update([
                        'two_factor_type' => 'sms'
                    ]);
                    return redirect(route('two_factor_auth'));
                } else {
                    //
                }
                $request->user()->update([
                    'two_factor_type' => 'sms'
                ]);
            } elseif ($data['type'] === 'off'){
                $request->user()->update([
                    'two_factor_type' => 'sms'
                ]);
                return redirect('/profile/twofactorauth');
            }
        } else {
            
        }
        
    }
}
