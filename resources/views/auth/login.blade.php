@extends('layouts.app')
@section('style')
<link href="{{ asset('css/form.css') }}" rel="stylesheet">
<style>
.form-group button {
    width: 100%;
    height: 40px;
}

.form-group button[type=submit] {
    background-color: #007bff;
    color: white;

}

.form-group button[type=button] {
    background-color: #F4F6F6;
    color: black;
}
/* .field-icon {
    font-size:20px;
    position: absolute;
    top: 50%; 
    transform: translate(-50%,-50%);
    right: 0;
    z-index:2;
} */
.field-icon {
    font-size:25px;
    position: relative;
    /* position: absolute;
    top: 50%;  */
    /* transform: translate(-50%,-50%); */
    /* right: 0; */
    z-index:100;
}
#password {
    /* padding: 1em; */
  /* margin: 0 -1em; */
    /* border-bottom-height: 130%; */
}
</style>
@endsection
@section('js')
<script>
$(document).ready(function() {
    console.log("ready!");
    $('.toggle-password').on('click', function() {
        $(this).toggleClass('fa-eye fa-eye-slash');
        let input = $($(this).attr('toggle'));
        if (input.attr('type') == 'password') {
            input.attr('type', 'text');
        } else {
            input.attr('type', 'password');
        }
    });
});
</script>
@endsection
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9" style="margin-top: 3%;">
            <div class="card" style="padding-bottom:-2% !important" >
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
                <center style="margin-top: 7%;">
                    <img src="img/bboLoginIcon.png" width="100" alt="logo">
                </center>
                <br>
                <form method="POST" class="container" action="{{ route('login') }}" style="margin-top: 10%;">
                    <div class="p-2">
                    @csrf
                    <div class="form-group  row">
                        <div class="col-md-10 mb-3  mx-auto">
                            <div class="md-form form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email"
                                    placeholder="Enter your email" autofocus>
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
                            <div class="input-group"
                             >
                                
                                <label for="password">Password</label>
                                <input 
                                    type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    placeholder="Enter your password"
                                    required autocomplete="current-password"
                                >
                                <div  class="input-group-append pt-2">
                                <span toggle="#password" class=" input-group-append fa fa-fw fa-eye field-icon toggle-password "></span>
                                </div>
                            </div>
                                
                                @error('password')
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-envelope"></span>
                                </div>
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
                                <strong>Log In</strong>
                            </button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div id="gmail" class="col-md-10 mx-auto">
                            <button type="button" onclick="window.location='{{ url("auth/google") }}'">
                                <img src="img/google_logo.png"
                                    style="float:left;margin-left:25px;width:27px;height:27px" alt="">
                                <strong style="margin-right:25px;">Login With Google</strong>
                            </button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div id="gmail" class="col-md-10 mx-auto">
                                @if (Route::has('password.request'))
                                <a class="btn btn-link" style="padding-left:0px!important;" href="/forget-password">
                                    Forgot Your Password ?
                                </a>
                                @endif
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
                        <div class="col-md-11  mx-auto">
                            <!-- <div class="form-check">
                                <div class="left">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        value="{{ old('remember') ? 'checked' : '' }}">
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div> -->
                            <!-- <div class="left">
                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="/forget-password">
                                    Forgot Your Password ?
                                </a>
                                @endif
                            </div> -->
                        </div>
                    </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
