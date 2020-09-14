@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 card" style="margin-top:3%;">
        <div class="card-body">
            <center>
                <img src="{{url('img/logoCircle.png')}}" width="100" alt="logo" style="margin-bottom:20px;">
            </center>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Username</label><br>
                    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                        name="email" value="{{ old('email') }}" placeholder="Enter your username" required autofocus>
                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>Invalid Email or Password</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password">Password</label><br>
                    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                        name="password" value="{{ old('password') }}" placeholder="********" required autofocus>
                    @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>  
                <div class="form-group row">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
                <div class="form-group row" style="margin-top:5%;">
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>
                    @if (Route::has('password.request'))
                        <button type="button" class="btn btn-warning" style="color:black; margin-top:1%;">
                            <a href="{{ route('password.request') }}">Forgot Your Password?</a>
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
