<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('img/favicon.png') }}" width="30" height="30" class="d-inline-block align-top" alt="">
        <h1 class="site-title d-inline">{{ \App\SiteSetting::first()->name }}</h1>
    </a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        </ul>
        <form action="{{ url('/search') }}/#posts" class="form-inline my-2 my-lg-0" method="get">
            <input name="q" class="form-control mr-sm-2" type="text" placeholder="Search" required>
            <button class="btn btn-outline-warning my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>
