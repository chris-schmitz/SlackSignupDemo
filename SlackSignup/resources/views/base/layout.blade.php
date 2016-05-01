<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css">
</head>
    <body>
        <div class="content">
            @include('base.partials._notifications')
            @yield('content')
        </div>
        @yield('extrascripts')
        <script src="/js/bundle.js"></script>
    </body>
</html>
