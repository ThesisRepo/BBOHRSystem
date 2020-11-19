@extends('layouts.app')
@auth
@section('js')
<script>
    localStorage.setItem('isloggedin', true)
</script>
@endsection
@section('content')
    <dashboard-view :user="{{auth()->user()->load('roles')->load('userInformation.department','userInformation.company_positions','assignedPrp', 'assignedFinance')}}"></dashboard-view>
@endsection
@endauth
