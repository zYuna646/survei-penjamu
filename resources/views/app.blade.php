<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @livewireStyles
    @yield('styles')
    <title>@yield('title')</title>
</head>

<body>
    @yield('content')
    @livewireScripts
    @yield('scripts')
</body>

</html>
