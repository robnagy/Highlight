<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Todoy @yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
{{--    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">--}}

</head>
<body>
<div id="app">
@section('navbar')
<header>
    <div class="collapse bg-dark" id="navbarHeader">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-md-7 py-4">
                    <h4 class="text-white">About</h4>
                    <p class="text-muted">Add your tasks for the day to the list below. Select a task to highlight it, add sub tasks, mark it complete, or to delete it.</p>
                </div>
                {{--<div class="col-sm-4 offset-md-1 py-4">--}}
                    {{--<h4 class="text-white">Contact</h4>--}}
                    {{--<ul class="list-unstyled">--}}
                        {{--<li><a href="#" class="text-white">Follow on Twitter</a></li>--}}
                        {{--<li><a href="#" class="text-white">Like on Facebook</a></li>--}}
                        {{--<li><a href="#" class="text-white">Email me</a></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
    <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container d-flex justify-content-between">
            <a href="#" class="navbar-brand d-flex align-items-center">
                <i class="far fa-eye"></i>
                <strong>HIGHLIGHT</strong>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</header>
@section('show')

<main role="main">
    <section class="jumbotron text-center">
        <div class="container">
            @yield('content')
        </div>
    </section>

</main>

<footer class="text-muted">
    <div class="container">
        <p class="float-right">
            <a href="#">Back to top</a>
        </p>
    </div>
</footer>
</div>

<script type="text/javascript" src="/js/app.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="/docs/4.2/assets/js/vendor/jquery-slim.min.js"><\/script>')</script><script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" crossorigin="anonymous"></script></body>
</html>
