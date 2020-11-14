@extends('layouts.app')
@section('style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
    <style>
    .form-group button{
        width:100%;
        height:40px;
    }
    .form-group button[type=submit]{
        background-color:#007bff;
        color:white;
        
    }
    .form-group button[type=button]{
        background-color:#F4F6F6 ;
        color:black;
    }
    </style>
@endsection
@section('js')
   <script>
   </script>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9" style="margin-top:3%;">
            <div class="card">
                <center style="margin-top: 3%;">
                    <img src="{{url('img/logo.png')}}" width="150" height="100" alt="logo">
                    <h4><b>Reset Password</b></h4>
                </center>
                <div class="card-body">
                    <form method="POST" action="/reset-password">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group  row" >
                            <div class="col-md-10 mb-3  mx-auto" >
                                <div class="md-form form-group">
                                    <label for="email">Email</label><br>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"  name="email"  value="{{ $email ?? old('email') }}" required autocomplete="email" placeholder="Enter your email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-10 mb-3 mx-auto">
                                <div class="md-form form-group">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="123456789" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-10 mb-3 mx-auto">
                                <div class="md-form form-group">
                                    <label for="password-confirm">Confirm Password</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="123456789" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-10  mx-auto">
                                <button type="submit">
                                   <strong>Reset Password</strong> 
                                </button>
                            </div>
                        </div> 

                        <!-- <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div> -->

                        <!-- <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div> -->

                        <!-- <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->

                        <!-- <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
