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
                    <h4><b>Request to Reset</b></h4>
                </center>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form method="POST"  action="/forget-password">
                        @csrf
                        <div class="form-group  row" >
                            <div class="col-md-10 mb-3  mx-auto" >
                                <div class="md-form form-group">
                                    <!-- <label for="email">Email</label><br> -->
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"  name="email"  value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email" autofocus>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Invalid Email or Password</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-10  mx-auto">
                                <button type="submit">
                                   <strong>Send Link</strong> 
                                </button>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <div class="form-group row">
                            <div class="col-md-10  mx-auto">
                                <center>
                                    <strong style="color:blue; cursor: pointer;" onclick="window.location='{{ url("login") }}'"><b>Back to Login</b></strong>
                                </center>
                            </div>
                        </div> 

                        <!-- <div class="form-group row mb-0" style="margin-top:5%;">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
