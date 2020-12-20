<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{!! asset('img/logoCircle.ico') !!}" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="/js/app.js" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <!-- <link href="{{ asset('css/form.css') }}" rel="stylesheet"> -->
</head>
@yield('style')

<style>
.col-md-7 {
    height: 100vh;
}

.col-md-7 main,
.col-md-5 main {
    position: relative;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
}

#name {
    height: 500px;
}
@media only screen and (max-width: 600px) {
  /* #welcome {
      display: none;
  } */
}
@media (min-width: 768px) {
    .h-md-100 {
        height: 100vh;
    }
}

</style>
@yield('js')

<body>  
    <div  id="app" class="container-fluid">
        @guest
        <div class=" row d-md-flex h-md-100 align-items-center" id="guest">

            <!-- First Half -->

            <div class="col-md-6 p-0 h-md-100">
                <div class="text-white d-md-flex align-items-center h-100 text-center justify-content-center">
                        <img src="{{url('images/background1.jpg')}}" width="100%" height="100%">              
                </div>
            </div>

            <!-- Second Half -->
            <div class="col-md-6 p-0 h-md-100 loginarea" style="background-color:#3490dc">
                <div class="container d-md-flex align-items-center h-100 justify-content-center">
                    @yield('content')
                </div>
            </div>
        </div>
        @endguest
        @auth
        <div id="app">
            <!-- <main class="py-4"> -->
                @yield('content')
            <!-- </main> -->
        </div>
        @endauth
    </div>
</body>
<script  type="text/javascript">
    window.onload = function() {
        if(document.getElementById('guest')) {
            console.log('storage cleared!');
            localStorage.clear();
        }
    }
</script>
</html>