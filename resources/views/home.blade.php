@extends('layouts.app')

@section('content')
@auth
    <dashboard-view :user="{{auth()->user()->load('roles')->load('userInformation.department', 'assignedPrp')}}"></dashboard-view>
@endauth

@endsection
