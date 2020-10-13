@extends('layouts.app')

@section('content')
@auth
    <dashboard-view :user="{{auth()->user()->load('roles')->load('userInformation')}}"></dashboard-view>
@endauth

@endsection
