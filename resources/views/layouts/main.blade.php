<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JobSerm</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
{{--TODO: NAVBAR, uncomment under this line--}}
{{--    @include('layouts.menu')--}}
    <div class="mx-auto min-h-screen bg-gray-100">
        @yield('content')
    </div>
    <div>
        FOOTER
    </div>
</body>
</html>
