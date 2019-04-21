@extends('layouts.blank')

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@section('title', $post->title . ' - ' . \App\SiteSetting::first()->name)

@section('content')
    @component('components.navbar')
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 bg-white p-5">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 p-4">
                            <nav>
                                <div class="categories">
                                    @foreach ($post->categories as $category)
                                        <a href="{{ url('/category/' . $category->slug) }}" class="category mb-3 mr-2 d-inline-block text-white">{{ $category->name }}</a>
                                    @endforeach
                                </div>
                            </nav>
                            <article class="post">
                                <h1>
                                    <b>
                                        {!! $post->title !!}
                                    </b>
                                </h1>
                                <div class="post-info text-uppercase text-black-50">
                                    <span class="author">{{ $post->author->name }}</span>
                                    <time datetime="{!! $post->updated_at !!}">{!! $post->updated_at->isoFormat('DD-MM-YYYY') !!}</time>
                                </div>
                                <div class="post-thumbnail mt-5 mb-5">
                                    <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}">
                                </div>
                                <div class="post-body">
                                    {!! $post->content !!}
                                </div>
                            </article>
                        </div>
                    </div>
                </div>

                @if ($post->comments_enabled)
                    <div id="disqus_thread"></div>
                    <script>
                    
                    var disqus_config = function () {
                        this.page.url = "{{ url()->current() }}";
                        this.page.identifier = "{{ $post->id }}";
                    };
        
                    (function() { // DON'T EDIT BELOW THIS LINE
                        var d = document, s = d.createElement('script');
        
                        s.src = 'https://lacms.disqus.com/embed.js';
                        s.setAttribute('data-timestamp', +new Date());
                        (d.head || d.body).appendChild(s);
                    })();
                    </script>
                    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                @endif
            </div>
            <div class="col-md-4 p-5">
                @component('components.popular-posts')
                @endcomponent
            </div>
        </div>
    </div>

    @component('components.footer')
    @endcomponent
@endsection