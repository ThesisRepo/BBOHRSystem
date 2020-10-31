@extends('layouts.app')

@section('content')
@auth
    <dashboard-view :user="{{auth()->user()->load('roles')->load('userInformation.department', 'assignedPrp', 'assignedFinance')}}"></dashboard-view>
@endauth

@endsection
