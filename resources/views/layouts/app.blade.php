<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{!! asset('images/bbo.ico') !!}"/>
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/form.css') }}" rel="stylesheet"> -->
</head>
@yield('style')

<style>
.col-md-7 {
    height:100vh;
}
.col-md-7 main, .col-md-5 main {
    position: relative;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}
#name {
    height:500px;
}
@media screen and (max-width: 800px) {
    #name {
    height: 300px;
  }
}
#companyName, #appName{
    font-size:50px;
}
#companyName{
    color:#3490dc
}
.col-md-7 {
    background-color:#3490dc;
}
</style>
@yield('js')
<body>
    <div id="app" class="container-fluid">
        @guest
            <div class="row">
                <div class="col-md-5" >
                    <main class="py-4" >
                        <div class="container-fluid" id="name"  >
                            <div class="row justify-content-center">
                                <div class="col-md-9" >
                                    <img  src="{{url('img/logo.png')}}" width="80" height="50" class="mb-5" alt="logo">
                                    <p id="companyName">BLUE BEE ONE </p>
                                    <p id="appName">REQUEST MANAGEMENT SYSTEM</p>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div id="app" class="col-md-7">
                    <main class="py-4">
                        @yield('content')
                    </main>
                </div>       
            </div>
        @endguest 
        @auth
            <div id="app">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        @endauth
    </div>
</body>
</html>