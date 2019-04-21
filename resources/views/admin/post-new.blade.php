@extends('layouts.admin')

@section('title', $title)

@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-editable.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules\choices.js\public\assets\styles\choices.min.css') }}">
@endpush

@section('content')
    <div class="row my-4">
        <div class="col-md-12">
            <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
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
                            <input type="text" name="title" class="form-control" placeholder="Post Title">
                        </div>
                        
                        <textarea name="content" id="editor" name="content"></textarea>

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
                        <div class="card mb-4 publish-card">
                            <div class="card-header">
                                Publish
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <b>Status:</b>
                                    <input class="ml-2" type="checkbox" id="published">
                                    <label class="published_label" for="published">
                                        Draft
                                    </label>
                                    <input type="hidden" name="published" value="0">
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-primary float-right">Save</button>
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
                                <div id="thumbnail-preview" style="display:none">
                                    Preview:
                                    <img src="#" alt="post thumbnail" class="mw-100 mt-2 mb-3">
                                </div>
                                <div class="custom-file">
                                    <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
                                    <input type="file" class="custom-file-input" id="customFile" name="thumbnail" accept="image/*">
                                    <label id="thumbnailLabel" class="custom-file-label" for="customFile">
                                        Choose file
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
@endsection

@push('scripts')
    <script src="{{ asset('js/ckfinder/ckfinder.js') }}"></script>
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="{{ asset('js/bootstrap-editable.min.js') }}"></script>
    <script src="{{ asset('node_modules\choices.js\public\assets\scripts\choices.min.js') }}"></script>
    <script>
        let choices = [
            @foreach ($categories as $category)
                {
                    value: "{{ $category->id }}",
                    label: "{{ $category->name }}",
                    selected: false,
                    disabled: false
                }{{ !$loop->last ? ',' : '' }}
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
    </script>
    <script src="{{ asset('js/post-new.js') }}"></script>
@endpush