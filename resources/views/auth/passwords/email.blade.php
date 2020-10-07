@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" style="margin-top:3%;">
            <div class="card">
                <center>
                    <img src="{{url('img/logoCircle.png')}}" width="100" alt="logo" style="margin-bottom:20px;">
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

                        <div class="form-group row mb-0" style="margin-top:5%;">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
