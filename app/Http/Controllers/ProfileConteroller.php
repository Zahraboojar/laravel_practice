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
}
