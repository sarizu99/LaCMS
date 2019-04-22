@extends('layouts.admin')

@section('title', $title)

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-editable.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules\choices.js\public\assets\styles\choices.min.css') }}">
@endpush

@section('content')
    <div class="row my-4">
        <div class="col-md-12">
            <form action="{{ url('/admin/post/' . $post->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <main class="col-md-8">
                        @if (session('msg'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                              <strong>{{ session('msg') }}</strong> 
                            </div>
                        @endif
        
                        <div class="form-group">
                            <input type="text" name="title" class="form-control" value="{{ $post->title }}">
                        </div>

                        <div class="form-group permalink">
                            Permalink : {{ url('/') }}/<a href="#" id="permalink">{{ strlen($post->slug) > 30 ? substr($post->slug, 0, 30) . '...' : $post->slug }}</a>
                            <a class="btn btn-sm btn-dark" target="_blank" href="{{ url('/' . $post->slug) }}">Preview</a>
                            <input type="hidden" name="slug" value="{{ $post->slug }}">
                        </div>
                        
                        <textarea name="content" id="editor" name="content">{{ old('content') ?: $post->content }}</textarea>

                        <div class="card mt-4">
                            <div class="card-header">
                                Comments
                            </div>
                            <div class="card-body">
                                <label class="form-check-label"><input type="radio" name="comments" autocomplete="off" value="1" checked> Enable</label>
                                <label class="form-check-label"><input type="radio" name="comments" autocomplete="off" value="0"> Disable</label>
                            </div>
                        </div>
                    </main>
                    <aside class="col-md-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="card mb-4 publish-card">
                            <div class="card-header">
                                Publish
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <b>Status:</b>
                                    <input class="ml-2" type="checkbox" id="published" {{ $post->published ? 'checked' : '' }}>
                                    <label class="published_label" for="published">
                                        @if ($post->published)
                                            Published
                                        @else
                                            Draft
                                        @endif
                                    </label>
                                    <input type="hidden" name="published" value="{{ $post->published ? 1 : 0 }}">
                                </div>
                                <hr>
                                <button data-toggle="modal" data-target="#modelId" type="button" class="btn btn-outline-danger">Delete</button>
                                <button type="submit" class="btn btn-primary float-right">Update</button>
                            </div>
                        </div>
                        <div class="card mb-4 categories-card">
                            <div class="card-header">
                                Categories
                            </div>
                            <div class="card-body">
                                <label for="categories">Search Existing Categories:</label>
                                <div class="form-group">
                                    <select id="categories" name="categories[]" multiple></select>
                                </div>
                                <div class="form-group mb-0">
                                  <label for="newCategory">+ New Category</label>
                                  <div class="d-none">
                                      <input name="new_categories[]" id="newCategory" type="text" class="form-control">
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                Thumbnail
                            </div>
                            <div class="card-body">
                                <div id="thumbnail-preview" {{ !$post->thumbnail ? 'style=display:none' : ''}}>
                                    Preview:
                                    <img src="{{ $post->thumbnail ? asset($post->thumbnail) : '#' }}" alt="post thumbnail" class="mw-100 mt-2 mb-3">
                                </div>
                                <div class="custom-file">
                                    <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
                                    <input type="file" class="custom-file-input" id="customFile" name="thumbnail" accept="image/*">
                                    <label id="thumbnailLabel" class="custom-file-label" for="customFile">
                                        @if ($post->thumbnail)
                                            Change thumbnail
                                        @else
                                            Choose file
                                        @endif
                                    </label>
                                </div>
                                <small class="form-text text-muted" id="thumbnailHelp">
                                    Image size must be larger than 350x220px
                                </small>
                            </div>
                        </div>
                    </aside>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this post?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">No</button>
                    <form action="{{ route('post.destroy', $post->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/ckfinder/ckfinder.js') }}"></script>
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="{{ asset('js/bootstrap-editable.min.js') }}"></script>
    <script src="{{ asset('node_modules\choices.js\public\assets\scripts\choices.min.js') }}"></script>
    <script>
        let items = [
            @foreach ($post->categories as $category)
                {
                    value: {{ $category->id }},
                    label: "{{ $category->name }}"
                }
                {{ !$loop->last ? ', ' : '' }}
            @endforeach
        ];

        let choices = [
            @foreach ($categories as $category)
                {
                    value: "{{ $category->id }}",
                    label: "{{ $category->name }}",
                    selected: 
                        @if (collect($post->categories)->contains('id', $category->id))
                            true
                        @else
                            false
                        @endif
                    ,
                    disabled: false
                }{{ !$loop->last ? ', ' : '' }}
            @endforeach
        ];

        var preview = $("#thumbnail-preview"),
            label = $("#thumbnailLabel"),
            help = $("#thumbnailHelp");

        $("[name=thumbnail]").change(function() {
            if (file = this.files && this.files[0]) {
                var fileName = this.files[0].name,
                    labelText = fileName.length < 30 ? fileName : fileName.substring(0, 20) + "...";

                label.text(labelText);

                var noImg = new Image();
                    img = new Image();

                noImg.src = window.URL.createObjectURL(file);
                img.src = window.URL.createObjectURL(file);
                
                img.onload = function() {
                    if (noImg.width >= 350 && noImg.height >= 220) {
                        preview.show();
                        
                        preview.find("img").attr("src", img.src);
                    } else {
                        preview.hide();

                        alert("Your selected image size is " + this.width + "x" + this.height + "px. Whilst the required minimum size is 350x220px. Please select another image!")

                        if (help.hasClass("text-muted")) {
                            help.show()
                                .toggleClass("text-muted")
                                .toggleClass("text-danger");
                        }
                    }
                }


            }
        });

        var makePermalinkUrl = "{{ url('/admin/make-permalink') }}",
            postSlug = "{{ $post->slug }}";
    </script>
    <script src="{{ asset('js/post-edit.js') }}"></script>
@endpush