@php
    $popular_posts = \App\Post::where('published', 1)->orderBy('views', 'desc')->take(\App\SiteSetting::first()->popular_at_most)->get()
@endphp

<div class="widget popular-posts">
    <h2 class="my-4">
        <span class="title-style d-inline-block">
            Popular Posts
        </span>
    </h2>
    <ul class="list-unstyled pt-3">
        @unless (count($popular_posts))
            No posts available.
        @endunless
        
        @foreach ($popular_posts as $pp)
            <li class="media {{ !$loop->last ? 'mb-4' : '' }}">
                <a href="{{ url('/' . $pp->slug) }}">
                    <div class="d-flex thumbnail mr-3" style="
                        background: no-repeat center/cover url({{ $pp->thumbnail ? asset($pp->thumbnail) : 'http://placehold.it/100x100' }});
                        width: 100px;
                        height: 100px;"></div>
                </a>
                <div class="media-body">
                    <h3 class="post-title"><a href="{{ url('/' . $pp->slug) }}">{{ $pp->title }}</a></h3>
                </div>
            </li>
        @endforeach
    </ul>
</div>