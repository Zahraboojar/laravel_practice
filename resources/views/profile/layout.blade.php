@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills card-header-pills">
                        <li class="nav-item">
                            <a class="nav-link @yield('profile.active')" href="{{ route('profile') }}">Index</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield('2fac.active')" href="{{ route('two_factor_auth') }}">Tow Factor Auth</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    @yield('profile.content')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
