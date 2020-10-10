@extends('layouts.app')

@section('content')
@auth
    <dashboard-view :user="{{auth()->user()->load('roles')}}"></dashboard-view>
@endauth
@endsection
