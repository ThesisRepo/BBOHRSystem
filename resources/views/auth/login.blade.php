@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" >
                <a href="https://locahost:8000">
                    <img src="http://localhost:8000/img/logoCircle.png" width="100" alt="logo">
                </a>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @error('invalid')
                            <div style="width:100%;text-align:center">
                            <span style="color:red;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            </div>
                        @enderror
                        @csrf

                        <div class="form-row">
                            <div class="col-md-10 mb-3 col-3 mx-auto">
                                <label for="username">Username</label>
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="email" value="{{ old('username') }}" placeholder="Enter your Username" required autocomplete="username" autofocus>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-10 mb-3 col-3 mx-auto">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" value="123456789">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-10 col-3 mx-auto">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>

                        <div class="form-row" id="form ">
                            <div class="col-md-10 col-3 mx-auto"> 
                                <div class="form-check" >
                                    <!-- <div class="col-md-12 bg-light text-left"> -->
                                    <div class="left" >
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                    </div>
                                </div>
                                <div class="right">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="/forget-password">
                                            Forgot Your Password ?
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>      
            </div>
        </div>
    </div>
</div>
@endsection
