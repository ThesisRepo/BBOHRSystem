@extends('layouts.app')

@section('content')
@auth
    <!-- <h1>{{auth()->user()->role->name}}</h1> -->
    <dashboard-view :user="{{auth()->user()}}"></dashboard-view>
@endauth
@endsection
