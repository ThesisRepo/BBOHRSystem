
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
@endsection
@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-9" style="margin-top: 3%;">
            <div class="card" > 
                <center> 
                @if(session()->has('message'))
                    <div class="alert alert-warning">
                        {{session('message') }}
                    </div>
                @endif
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{session('success') }}
                    </div>
                @endif
                @if(session()->has('invalidToken'))
                    <div class="alert alert-danger">
                        {{session('invalidToken') }}
                    </div>
                @endif   
                </center>     
                <center style="margin-top: 10%;">
                    <img src="img/user_logo.png" width="100" alt="logo">
                </center>
                <br>
                <div class="card-body" >
                    <form method="POST"  action="{{ route('login') }}">
                        @csrf
                        <div class="form-group  row" >
                            <div class="col-md-10 mb-3  mx-auto" >
                                <div class="md-form form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"  name="email"  value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email" autofocus>
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
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="123456789" required autocomplete="current-password" >
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
                                   <strong>Sign In</strong> 
                                </button>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <div id ="gmail" class="col-md-10 mx-auto">
                                <button type="button" onclick="window.location='{{ url("auth/google") }}'">
                                    <img src="img/google_logo.png" style="float:left;margin-left:25px;width:27px;height:27px" alt="">
                                    <strong style="margin-right:25px;">Login With Google</strong>
                                </button>
                            </div>
                        </div>
                        @error('invalid')
                            <div style="width:100%;text-align:center">
                            <span style="color:red;">
                                    {{ $message }}
                                </span>
                            </div>
                        @enderror
                        <div class="form-group row">
                            <div class="col-md-10  mx-auto"> 
                                <div class="form-check">    
                                    <div class="left">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"  value = "{{ old('remember') ? 'checked' : '' }}">
                                        <label class="form-check-label" for="remember">
                                            Remember Me
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

 <!-- <div class="row justify-content-center">
        <div class="col-md-8" style="margin-top: 3%;">
            <div class="card" >
               
                <center style="margin-top: 3%;">
                    <img src="img/logoCircle.png" width="100" alt="logo">
                </center>
           
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @error('invalid')
                            <div style="width:100%;text-align:center">
                            <span style="color:red;">
                                    <strong>Incorrect email or password</strong>
                                </span>
                            </div>
                        @enderror
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-10 mb-3 col-3 mx-auto">
                                <div class="md-form form-group">
                                    <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"  name="email"  value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-10 mb-3 col-3 mx-auto">
                                <div class="md-form form-group">
                                    <label for="password">Password</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="123456789" required autocomplete="current-password" >
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                </div>
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <div class="col-md-10 col-3 mx-auto">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Login
                                </button>
                            </div>
                        </div> 
                        <div id ="gmailDiv" class="col-md-10 col-3 mx-auto">
                            <a href="{{ url('auth/google') }}" class="btn btn-lg btn-default btn-block">
                                <img id ="gmail" src="img/google_logo.png" alt="">
                                <strong>Login With Google</strong>
                            </a> 
                        </div>
                        <div class="form-group row">
                            <div class="col-md-10 col-3 mx-auto"> 
                                <div class="form-check">    
                                    <div class="left">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"  value = "{{ old('remember') ? 'checked' : '' }}">
                                        <label class="form-check-label" for="remember">
                                            Remember Me
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
    </div> -->
