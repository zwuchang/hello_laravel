<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') Laravel5.5 - 练手小项目 </title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    @include('layouts._header');
    {!! csrf_field() !!}
    <div class="container" id="app">
        <div class="col-md-offset-1 col-md-10">
            @include('shared._messages')
            @yield('content')
            @include('layouts._footer')
        </div>
    </div>

    <script src="/js/app.js"></script>
</body>
</html>