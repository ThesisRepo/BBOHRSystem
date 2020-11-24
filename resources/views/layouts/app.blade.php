<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{!! asset('img/logoCircle.ico') !!}"/>
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="/js/app.js" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
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
/* @media screen and (max-width: 800px) {
    #name {
    height: 300px;
  }
} */
/* #companyName, #appName{
    font-size:250%;
}
#companyName{
    color:#3490dc
}
.col-md-7 {
    background-color:#3490dc;
} */
@media (min-width: 768px) {
    .h-md-100 { height: 100vh; }
}
.bg-indigo { background: indigo; }
</style>
@yield('js')
<body>
    <div id="app" class="container-fluid">
        @guest
        <div class="d-md-flex h-md-100 align-items-center">

            <!-- First Half -->

            <div class="col-md-6 p-0 h-md-100">
                <div class="text-white d-md-flex align-items-center h-100 text-center justify-content-center" style="background-color:red"> 
                    <!-- <div class="logoarea pt-0 pb-0">
                        <img src="{{url('images/background1.jpg')}}" width="630" height="670">
                    </div> -->
                </div>
            </div>

            <!-- Second Half -->

            <div class="col-md-6 p-0 h-md-100 loginarea" style="background-color:#3490dc">
                <div class="d-md-flex align-items-center h-100 justify-content-center">
                    @yield('content')
                </div>
            </div>
                
        </div>
            <!-- <div class="row">
                <div class="col-md-5" >
                    <main class="py-4" >
                        <div  id="name">
                            <div class="row justify-content-center">
                                <div class="col-md-9" style="top:0%;">
                                    <img  src="{{url('images/background.png')}}" width="500" height="500"> -->
                                    <!-- <p id="companyName">BLUE BEE ONE </p>
                                    <p id="tag"><i>"The name of our company comes from Blue Bee. The blue bee is said to bring happiness and make a path of happiness, which exists in each one of us."</i></p>
                                    <p id="appName">REQUEST MANAGEMENT SYSTEM</p> -->
                                <!-- </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div class="col-md-7">
                    <main class="py-1">
                        @yield('content')
                    </main>
                </div>       
            </div> -->
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