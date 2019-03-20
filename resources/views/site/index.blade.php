<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
    <link rel="stylesheet" href="{{ asset('css/site.index.css') }}">

    <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>

    <title>{{ env('APP_NAME') }}</title>
</head>
<body>
<div id="header">
    <a class="brand-logo" href="http://nsbm.ac.lk">
        <img id="nsbm-logo" src="{{ asset('png/nsbm.png') }}" alt="NSBM">
    </a>
    <div id="links">
        <a href="{{ route('students.index') }}">Student</a>
        <a href="{{ route('companies.index') }}">Company</a>
        <a href="">About</a>
    </div>
</div>
<main>
    <img id="logo" src="{{ asset('png/CareerHub.png') }}" alt="{{ env('APP_NAME') }}">
    <small>Copyright © 2019 <strong>National School of Business Management Ltd.</strong> All Rights Reserved.</small>
</main>

</body>
</html>