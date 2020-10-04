@extends('layouts.app')

@section('content')
@auth
    <div>
        <dashboard-view />
    </div>
@endauth
@endsection
