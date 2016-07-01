<!-- Stored in resources/views/layouts/master.blade.php -->

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lab 11</title>
    <!-- Latest compiled and minified CSS --><!--
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!-- Optional theme --> <!--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <!-- jQuery library --> <!--
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <!-- Latest compiled JavaScript --> <!--
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    @yield('topScript')
    @yield('css')
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"> TOP BAR </a>
            </div>
        </div>
    </nav>
    <div class="jumbotron">
        <div class="container">
            <h2> {{ $title }} </h2>
            <p> Header description </p>
            @yield('sidebar')
        </div>
    </div>

    <div class="container">
        @yield('content')
    </div>


    <div class="container">
        <footer>
            <hr/>
            (c) 2016 Universiti Putra Malaysia. All rights reserved.
        </footer>
    </div>

    @yield('script')
</body>
</html>