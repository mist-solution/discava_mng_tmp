<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Vue Laravel SPA') }}</title>

    <!-- Styles -->
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <!-- favicon -->
    <!-- <link rel="icon" href="{{ url('/images/discavamate.ico') }}"> -->
    <link rel="icon" href="{{ url('/images/favicon.ico') }}">
    <!-- <link rel="icon" href="{{ url('/path/to/favicon.ico') }}"> -->
    <!-- <link rel="icon" href="https://mate.discava.net/images/discavamate.ico"> -->
</head>

<body>
    <div id="app">
        <app></app>
    </div>
    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}" defer>
    </script>
</body>

</html>