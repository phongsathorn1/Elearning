<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Elearning') }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/design.css') }}" rel="stylesheet">
    <script>
        window.Laravel = {
            'baseUrl': "{{ url('/') }}"
        }
    </script>
</head>
<body>
    <div id="app">
        <div id="login-page">
            <div class="container">
                <div class="login-form">
                    <img src="{{ url('/images/logo-full.svg') }}">
                </div>
            </div>
            <div class="object">
                <div class="overlay-bg">
                </div>
                <div class="star-1">
                    <img src="{{ url('/images/login/star_Ly4.png') }}" class="img-responsive">
                </div>
                <div class="star-2">
                    <img src="{{ url('/images/login/star2_Ly4.png') }}" class="img-responsive">
                </div>
                <div class="mountain mountain-5"></div>
                <div class="mountain mountain-4"></div>
                <div class="mountain mountain-3"></div>
                <div class="mountain mountain-2"></div>
                <div class="mountain mountain-1"></div>
                <div class="cloud cloud-4"></div>
                <div class="cloud cloud-3"></div>
                <div class="cloud cloud-2"></div>
                <div class="cloud cloud-1"></div>
            </div>
        </div>
    </div>
</body>
