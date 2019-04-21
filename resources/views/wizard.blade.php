@extends('layouts.blank')

@section('title', $title)

@section('content')
    <div class="container">
        <div class="col-12 my-5">
            <div class="text-center">
                <h1>Welcome to Setup Wizard!</h1>
                <p>Please fill all the fields below to setup this amazing site!</p>
            </div>
            <form action="{{ url()->current() }}" method="post">
                @csrf
                <div class="container-fluid mt-5">
                    <div class="row">
                        <div class="col-6">
                            <h4>General</h4>

                            <div class="form-group">
                              <label for="SiteName">Site Name</label>
                              <input type="text" name="site_name" id="SiteName" class="form-control" placeholder="e.g. Blog Perusahaan Lele" value="{{ old('site_name') }}">
                              <small class="text-muted">Your new awesome site name</small>
                            </div>

                            <div class="form-group">
                              <label for="site_description">Site Description</label>
                              <textarea class="form-control" name="site_description" id="site_description" rows="4" placeholder="e.g. Update berita terbaru terkait aktivitas bisnis dari Perusahaan Lele">{{ old('site_description') }}</textarea>
                              <small class="text-muted">Describe what this site about</small>
                            </div>

                            <h4>Blog</h4>

                            <div class="form-group">
                              <label for="ShowAtMost">Post per page</label>
                              <input type="number" min="1" name="show_at_most" id="ShowAtMost" class="form-control" placeholder="7" value="{{ old('show_at_most') }}">
                              <small class="text-muted">Number of posts to show on main page</small>
                            </div>

                            <div class="form-group">
                              <label for="Pop">Popular post</label>
                              <input type="number" min="1" name="popular_at_most" id="Pop" class="form-control" placeholder="7" value="{{ old('popular_at_most') }}">
                              <small class="text-muted">Number of popular posts to show on your blog</small>
                            </div>

                            <div class="form-group">
                              <label for="Snippet">Post Snippet</label>
                              <input type="number" min="0" name="snippet_length" id="Snippet" class="form-control" placeholder="300" value="{{ old('snippet_length') }}">
                              <small class="text-muted">Short description of each posts on main page</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4>Account</h4>

                            <div class="form-group">
                              <label for="UN">Name</label>
                              <input type="text" name="name" id="UN" class="form-control" placeholder="e.g. John Doe"  value="{{ old('name') }}">
                              <small class="text-muted">Admin account name</small>
                            </div>

                            <div class="form-group">
                              <label for="email">Email</label>
                              <input type="email" name="email" id="email" class="form-control" placeholder="e.g. johndoe@example.com"  value="{{ old('email') }}">
                              <small class="text-muted">Your active email</small>
                            </div>

                            <div class="form-group">
                              <label for="Pass">Password</label>
                              <input type="password" name="password" id="Pass" class="form-control">
                              <small class="text-muted">Make sure it's unguessable!</small>
                            </div>

                            <div class="form-group">
                              <label for="PassC">Password Confirmation</label>
                              <input type="password" name="password_confirmation" id="PassC" class="form-control">
                              <small class="text-muted">Repeat your password here</small>
                            </div>

                            <button type="submit" class="btn btn-outline-primary float-right">Finish</button>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection