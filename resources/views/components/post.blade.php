<article class="post col-md-6 mb-5 px-4">
    <a href="{{ url($post->slug) }}">
        <div class="thumbnail">
            <div class="cover"></div>
            @if ($post->thumbnail)
            <img src="{{ asset($post->thumbnail) }}" alt="image thumbnail">
            @else
            <img src="{{ asset('img/350x220.png') }}" alt="no thumbnail">
            @endif
        </div>
        <h3 class="post-title my-3">
            {{ $post->title }}
        </h3>
    </a>
    <div class="post-info text-uppercase text-black-50 mb-2">
        {{ $post->author->name }} <span class="d-inline-block mx-2">|</span> {{ $post->updated_at->isoFormat('DD MMMM YYYY') }}
    </div>
    <div class="snippet post-content mb-1">
        {!! $post->content !!}...
    </div>
    <div class="categories mt-3">
        @foreach ($post->categories as $category)
            <a href="{{ url('/category/' . $category->slug) }}" class="category mt-2 mr-2 d-inline-block text-white">{{ $category->name }}</a>
        @endforeach
    </div>
</article>