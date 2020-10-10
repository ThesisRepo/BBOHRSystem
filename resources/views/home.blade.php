@extends('layouts.app')

@section('content')
@auth
<<<<<<< HEAD
    <dashboard-view />
=======
    <dashboard-view :user="{{auth()->user()->load('roles')}}"></dashboard-view>
>>>>>>> 8f24fe55f9a86935501a4b565bd53e653668ac6a
@endauth
@endsection
