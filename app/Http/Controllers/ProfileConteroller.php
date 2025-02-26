<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                //set tow factor
            } else if ($data['type'] === 'off'){
                $request->user()->update([
                    'two_factor_auth' => 'off'
                ]);
                
            }
        } else {
            return redirect('/profile/twoauthfactor');
        }
        
    }
}
