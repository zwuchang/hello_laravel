<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') Laravel5.5 - 练手小项目 </title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
    <header class="navbar navbar-fixed-top navbar-inverse">
        <div class="container">
            <div class="col-md-offset-1 col-md-10">
                <a href="/" id="logo">Sample App</a>
            </div>
            <nav>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/">首页</a></li>
                    <li><a href="/help">帮助</a></li>
                    <li><a href="javascript:alert('暂未准备好！');">登录</a></li>
                    <li><a href="/about">关于</a></li>
                </ul>
            </nav>
        </div>
    </header>
    @yield('content')
</body>
</html>