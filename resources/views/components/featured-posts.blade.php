@php
    $p = \App\Post::where('published', 1)->inRandomOrder()->take(5)->get();
@endphp

@if ($p->count() >= 5)
    <div class="container-fluid featured-posts">
        <div class="row">
            <article class="featured-post big-post col-md-6 col-sm-12 px-0" style="background-image:url({{ $p[0]->thumbnail ?: '//placehold.it/350x220' }})">
                <a href="{{ url('/' . $p[0]->slug) }}" class="cover_url"></a>
                <div class="cover"></div>
                <h3 class="post-title">{{ $p[0]->title }}</h3>
                <div id="posts" style="position: absolute;bottom: 25px;"></div>
            </article>
            <div class="col-md-6 px-0 small-featured">
                <div class="container-fluid">
                    <div class="row">
                        <article class="featured-post col-sm-6 px-0" style="background-image:url({{ $p[1]->thumbnail ?: '//placehold.it/350x220' }})">
                            <a href="{{ url('/' . $p[1]->slug) }}" class="cover_url"></a>
                            <div class="cover"></div>
                            <h3 class="post-title">{{ $p[1]->title }}</h3>
                        </article>
                        <article class="featured-post col-sm-6 px-0" style="background-image:url({{ $p[2]->thumbnail ?: '//placehold.it/350x220' }})">
                            <a href="{{ url('/' . $p[2]->slug) }}" class="cover_url"></a>
                            <div class="cover"></div>
                            <h3 class="post-title">{{ $p[2]->title }}</h3>
                        </article>
                        <article class="featured-post col-sm-6 px-0" style="background-image:url({{ $p[3]->thumbnail ?: '//placehold.it/350x220' }})">
                            <a href="{{ url('/' . $p[3]->slug) }}" class="cover_url"></a>
                            <div class="cover"></div>
                            <h3 class="post-title">{{ $p[3]->title }}</h3>
                        </article>
                        <article class="featured-post col-sm-6 px-0" style="background-image:url({{ $p[4]->thumbnail ?: '//placehold.it/350x220' }})">
                            <a href="{{ url('/' . $p[4]->slug) }}" class="cover_url"></a>
                            <div class="cover"></div>
                            <h3 class="post-title">{{ $p[4]->title }}</h3>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif