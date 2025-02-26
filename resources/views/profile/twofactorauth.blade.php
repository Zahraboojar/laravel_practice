@extends('profile.layout')

@section('profile.content')
    <h4>two factor auth</h4>
    <hr>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $errors_item)
                    <li> {{ $errors_item }} </li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="/profile/twofactorauthrequest" method="post">
        @csrf
        <div class="form-group">
            <label for="type">Type :</label>
            <select name="type" id="type" class="form-control">
                @foreach (config('towfactor.types') as $key => $name)
                    <option value="{{ $key }}" {{ old('type') === $key || auth()->user()->HasTwoFactorAuth($key) ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="type">Phone :</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone')?? auth()->user()->phone_number }}">
        </div>

        <div class="form-group mt-4">
            <button class="btn btn-primary">
                 Submit 
            </button>
        </div>
    </form>

@endsection