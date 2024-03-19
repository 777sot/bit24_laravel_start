<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<nav class="navbar">
    <div class="container">
        <a class="active" href="/">Единый формат для телефонных номеров</a>
        <a class="" href="/licenses">Лицензии</a>
        <a href="https://auth2.bitrix24.net/oauth/select/?preset=im&amp;IM_DIALOG=networkLines7575d3350d49d47db7bea9beac4b7994" target="_blank">Помощь</a>
        <a class="" href="/offer">Предложение по доработкам</a>
        <a class="" href="/instructions">Instructions</a>
        <a class="" href="/about-us">О нас</a>
    </div>
</nav>
<div id="app">

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
