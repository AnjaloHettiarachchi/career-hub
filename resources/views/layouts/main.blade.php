<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="{{ asset('css/layout.main.css') }}">
    @yield('css')

    <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.close.icon').on('click', function () {
                    $(this).closest('.message').transition('fade down');
                }
            );
        });
    </script>

    @yield('js')

    <title>{{ $title }}</title>
</head>

<body class="Site">

<header>
    <div id="nav" class="ui middle attached inverted menu">
        <a id="logo-container" class="item" href="{{ route('site.index') }}">
            <img id="logo" src="{{ asset('png/CareerHub.png') }}" alt="{{ env('APP_NAME') }}">
        </a>
        <div id="nav-right" class="right menu">
            @yield('nav')
        </div>
    </div>
</header>

<main class="Site-content">
    @yield('content')
</main>

<footer>
    <small>Copyright © 2019 <strong>National School of Business Management Ltd.</strong> All Rights Reserved.</small>
</footer>

</body>
</html>