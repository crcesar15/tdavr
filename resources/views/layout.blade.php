<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>TDAVR</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="icon" href="{{asset('images/favicon.ico')}}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        @stack('styles')
        <!--Scripts-->
        <script src="{{asset('js/app.js')}}"></script>
        @stack('scripts')
    </head>
    <body>
        @yield('nav_bar')
        @yield('content')
        @yield('footer')
    </body>
</html>
