<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('home') }}">Flickr Search</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li @if (str_is('home', Route::current()->getName())) class="active" @endif><a href="{{ route('home') }}">Home</a></li>
            </ul>
        </div>
    </div>
</nav>