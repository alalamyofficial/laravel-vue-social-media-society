<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="turbolinks-cache-control" content="no-preview">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet"> -->
    
    <link rel="stylesheet" href="{{asset('user/css/tailwind.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/tailwind.min.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/base.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/components.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/components.min.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/utilities.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/utilities.min.css')}}">
    <link rel="stylesheet" href="{{asset('fonts/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('fonts/css/all.css')}}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">



        <div class="flex">

            @auth
            <sidebar class="p-6 border shadow" style="width:290px; position:fixed; margin-top: 55px; 
            height:700px"></sidebar>
            @endauth


            <main class="py-4" style="width:3000px; position:relative; left:70px; margin-top: 55px;">
                @yield('content')
            </main><br>

            @auth
            <section class="lg:w-1/6 bg-white-100 rounded-lg p-4" style="margin-top: 55px;">
                @include('suggest')
            </section><br>
            @endauth


            @auth
            <section class=" bg-white-100 rounded-lg p-4" style="margin-top: 400px;">
                @include('quotes')
            </section><br>
            @endauth


            @auth
            <div style="position:fixed; width: 1440px;">
                @include('layouts.navbar')
            </div>
            @endauth

        </div>

        <!-- <router-view></router-view> -->


    </div>


    </body>
</html>
