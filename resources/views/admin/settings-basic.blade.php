@extends('layouts.admin')

@section('title', $title)

@section('content')
    <div class="row">
        <div class="col-md-8 mt-4 mb-5">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong>{{ session('success') }}</strong> 
                </div>
            
                <script>
                    $(".alert").alert();
                </script>
            @endif

            <form action="{{ url()->current() }}" method="post">
                @csrf
                @method('put')

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif                

                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>
                                <label for="SiteName">Site Name</label>
                            </td>
                            <td>
                                <input type="text" name="name" id="SiteName" class="form-control" value="{{ $site->name }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="SiteDescription">Description</label>
                            </td>
                            <td>
                                <textarea name="description" id="SiteDescription" class="form-control" rows="3">{{ $site->description }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="ShownPosts">Show posts at most</label>
                            </td>
                            <td>
                                <input type="number" min="1" max="100" name="show_at_most" id="ShownPosts" class="form-control" value="{{ $site->show_at_most }}">
                                <small class="text-muted">Number of posts to show on main page</small>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="SnippetLength">Post snippet length</label>
                            </td>
                            <td>
                                <input type="number" min="0" name="snippet_length" id="SnippetLength" class="form-control" value="{{ $site->snippet_length }}">
                                <small class="text-muted">The length of snippet</small>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="PopularPostsAtMost">Show popular posts at most</label>
                            </td>
                            <td>
                                <input type="number" min="1" name="popular_at_most" id="PopularPostsAtMost" class="form-control" value="{{ $site->popular_at_most }}">
                                <small class="text-muted">Number of posts to show on popular posts</small>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button class="btn btn-primary float-right">Update</button>
            </form>
        </div>
    </div>
@endsection