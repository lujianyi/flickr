<!DOCTYPE html>
<html>
    <head>
        <title>Search Photo</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
              integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
              integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

        <link rel="stylesheet" href="/css/main.css">

    </head>
    <body>
        <header id="nav-bar">
            <div class="container">
                <div class="row">
                    @include('layouts._navbar')
                </div>
            </div>
        </header>
        <div class="container">
            <div class="content">
                @yield('content')
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <p>Designed and built by Jianyi (Jerry) LU</p>
                </div>
            </div>
        </footer>
    </body>
</html>
