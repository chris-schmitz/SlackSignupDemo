<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <meta id="token" name="token" value="{{ csrf_token() }}">
</head>
    <body>
        <div class="container">
            @yield('content')
        </div>
        <script src="/js/jquery.js"></script>
        <script src="/js/bundle.js"></script>
        @yield('extrascripts')
    </body>
</html>
