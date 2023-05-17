<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://kit.fontawesome.com/8d4167dd12.js" crossorigin="anonymous"></script>
    @vite(['resources/js/app.js', 'resources/js/vanilla/css-base.js'])
    <title>{{ config('app.name') }}</title>
</head>
<body>
    @yield('content')
</body>
</html>