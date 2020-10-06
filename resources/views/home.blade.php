@extends('layouts.app')

@section('content')
@auth
    <dashboard-view />
@endauth
@endsection
