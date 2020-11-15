@extends('layouts.app')

@section('content')
@auth
    <dashboard-view :user="{{auth()->user()->load('roles')->load('userInformation.department','userInformation.company_positions','assignedPrp', 'assignedFinance')}}"></dashboard-view>
@endauth

@endsection
