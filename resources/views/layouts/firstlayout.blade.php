<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>
        @yield('title')
    </title>
</head>
<body>
    <div class="container pt-5 pb-5">
        @yield('contents')
    </div>
</body>
</html>