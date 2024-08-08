<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STAXO SHOP: @yield('title',config('app.name', 'Laravel'))</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    @yield('styles')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body >
        @include('layouts.navbar')
        @yield('content')
        @include('layouts.footer')
        @yield('script')
</body>
</html>