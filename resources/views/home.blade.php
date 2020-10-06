@extends('layouts.app')

@section('content')
@auth
<div>
    <dashboard/>
</div>
@endauth
@endsection
