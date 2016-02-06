<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Новости</title>
    {!! Html::style('vendors/bootstrap/dist/css/bootstrap.min.css') !!}
    {!! Html::style('vendors/bootstrap/dist/css/bootstrap-theme.min.css') !!}

    @if(env('APP_DEBUG', false))
        {!! Html::style('css/app.css') !!}
    @else
        {!! Html::style('css/app.min.css') !!}
    @endif

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Новостной портал</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/feed">Все новости</a></li>
                </ul>

                <form method="get" action="/search" class="navbar-form navbar-right" role="search">
                    <div class="form-group">
                        <input type="text" name="q" required class="form-control" placeholder="Поиск" value="<?= isset($q) ? $q : '' ?>">
                    </div>
                    <button type="submit" class="btn btn-default">Найти</button>
                </form>

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/about">О сайте</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">

        @yield('content')

    </div>

    {!! Html::script('vendors/jquery/dist/jquery.min.js') !!}
    {!! Html::script('vendors/bootstrap/dist/js/bootstrap.min.js') !!}
</body>
</html>