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
    p {
        font-size: 15px;
    }
    </style>
@endsection
@section('js')
   <script>
   </script>
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-5" style="margin-top:10%;">
            <div class="card">
                <center style="margin-top: 3%;">
                    <img src="{{url('img/logo.png')}}" width="150" height="100" alt="logo">
                    <h4><b>Verification of Email Address</b></h4>
                </center>
                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                    <center>
                        <p>Before proceeding, please check your email for a verification link. If you did not receive the email, </p>
                    </center>
                    <!-- {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, -->
                    @if (Route::has('verification.resend'))
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <div class="form-group row">
                            <div class="col-md-10  mx-auto">
                                <center>
                                    <button type="submit" style="cursor:pointer"><b>Resend verification link</b></button>
                                </center>
                            </div>
                        </div> 
                            <!-- <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>. -->
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
