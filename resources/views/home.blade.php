@extends('layouts.app')

@section('content')
@auth
<<<<<<< HEAD
    <dashboard-view :user="{{auth()->user()->load('roles')->load('userInformation.department','userInformation.company_positions', 'assignedPrp', 'assignedFinance')}}"></dashboard-view>
=======
    <dashboard-view :user="{{auth()->user()->load('roles')->load('userInformation.department','userInformation.company_positions','assignedPrp', 'assignedFinance')}}"></dashboard-view>
>>>>>>> 601d74ce67306c5d4c79804d1e85d6c8b260bcc7
@endauth

@endsection
