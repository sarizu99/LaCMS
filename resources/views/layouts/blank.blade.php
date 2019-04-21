<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @push('stylesheets')
        <link href="{{ asset('node_modules\@fortawesome\fontawesome-free\css\all.min.css') }}" rel="stylesheet">
        <link href="{{ asset('node_modules\bootstrap\dist\css\bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <meta name="description" content="{{ \App\SiteSetting::count() ? \App\SiteSetting::first()->description : '' }}">
    @endpush
    @stack('stylesheets')
</head>
<body>
    @yield('content')
    @prepend('scripts')
        <script src="{{ asset('node_modules\jquery\dist\jquery.min.js') }}"></script>
        <script src="{{ asset('node_modules\bootstrap\dist\js\bootstrap.bundle.min.js') }}"></script>
    @endprepend
    @stack('scripts')
</body>
</html>