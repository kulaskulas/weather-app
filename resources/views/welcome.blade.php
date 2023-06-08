<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('owfont-master/demo/css/owfont-regular.css')}}">
    </head>
    <body class="bg-fixed bg-cover h-full bg-cover bg-no-repeat" style="background-image: url({{asset('images/weather-bg.jpg')}})">
        <div id="app" class="flex justify-center"></div>
        <script src="{{ asset('js/app.js') }}" defer></script>
    </body>
</html>
