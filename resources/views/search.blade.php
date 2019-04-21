@extends('layouts.blank')

@section('title', $title)

@section('content')
    @component('components.navbar')
    @endcomponent

    @component('components.featured-posts')
    @endcomponent

    <div class="container-fluid">
        <div class="row justify-content-center">
            <main class="col-md-8 posts">
                <div class="container-fluid p-5">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <h2 class="latest-post my-4 pl-2">
                                <span class="d-inline-block title-style">
                                    Search Results
                                </span>
                            </h2>
                        </div>
                        @unless (count($posts))
                            <div class="col-12">
                                No posts available.
                            </div>
                        @endunless
                        @each('components.post', $posts, 'post')
                    </div>
                </div>
                {{ $posts->links() }}
            </main>
            <aside class="col-md-4 p-5">
                @component('components.popular-posts')
                @endcomponent
            </aside>
        </div>
    </div>
    @component('components.footer')        
    @endcomponent
@endsection
