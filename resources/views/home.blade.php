@extends('layouts.app')
@section('js')
<script>
    localStorage.setItem('isloggedin', true)
</script>
@endsection
@section('content')
@auth
    <dashboard-view :user="{{auth()->user()->load('roles')->load('userInformation.department','userInformation.company_positions','assignedPrp', 'assignedFinance')}}"></dashboard-view>
   
@endauth

@endsection
