@extends('layouts.app')

@section('content')
<<<<<<< HEAD
@auth
    
    <dashboard-view :user="{{auth()->user()->load('roles')}}"></dashboard-view>
@endauth
=======
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>df
>>>>>>> 0016827f984ec2d3ddcaf702ae018744081de7b6
@endsection
