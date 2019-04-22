@extends('layouts.admin')

@section('title', $title)

@section('content')
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Add New Category
                </div>
                <div class="card-body">
                    <form action="{{ url()->current() }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="Name">Name</label>
                            <input class="form-control" type="text" name="name" id="Name">
                            <p class="form-text text-muted">
                                The name is how it appears on your site.
                            </p>
                        </div>
        
                        <div class="form-group">
                            <label for="Slug">Slug</label>
                            <input class="form-control" type="text" name="slug" id="Slug">
                            <p class="form-text text-muted">
                                The "slug" is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens (-).
                            </p>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Add
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong>{{ session('success') }}</strong> 
                </div>
                
                <script>
                  setTimeout(() => {
                    $(".alert-success").slideUp();
                  }, 3000);
                </script>
            @endif

            @if (session('danger'))
                <div class="alert alert-danger alert-dismissible show" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong>{{ session('danger') }}</strong> 
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    Manage Categories
                </div>
                <div class="card-body">
                    <table class="categories table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $c)
                                <tr>
                                    <td>
                                        {{ $c->id }}
                                    </td>
                                    <td>
                                        {{ $c->name }}
                                        <div class="show-hover category-actions">
                                            <button class="btn btn-sm btn-outline-secondary update-post" onclick="updateCategory(this)" data-id="{{ $c->id }}" data-name="{{ $c->name }}" data-slug="{{ $c->slug }}">Edit</button>
                                            <button class="btn btn-sm btn-danger delete-post" onclick="deleteCategory(this)" data-id="{{ $c->id }}">Delete</button>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $c->slug }}
                                    </td>
                                </tr>
                            @endforeach
            
                            @unless (isset($categories))
                                <tr>
                                    <td colspan="No categories"></td>
                                </tr>
                            @endunless
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateCategory" tabindex="-1" role="dialog" aria-labelledby="updateCategory" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Enter the new values</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @method('put')
                        <table class="">
                            <tbody>
                                <tr>
                                    <td class="pr-4">
                                        <label for="Name">Name</label>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" name="name" id="Name">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <p class="form-text text-muted">
                                            The name is how it appears on your site.
                                        </p>
                                    </td>
                                </tr>
                                <tr class="invisible">
                                    <td>a</td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Slug">Slug</label>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" name="slug" id="Slug">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <p class="form-text text-muted">
                                            The "slug" is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens (-).
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteConf" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmation" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this category?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">No</button>
                    <form action="" method="post">
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
    <script src="{{ asset('node_modules\datatables.net\js\jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('node_modules\datatables.net-bs4\js\dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $('.categories').DataTable({
            order: [[ 0, "desc" ]]
        });

        var updateCategory = el => {
            var updateCategory = $('#updateCategory');

            updateCategory.find('form').attr('action', '{{ url('/admin/category') }}/' + el.dataset.id);
            updateCategory.find('[name=name]').val(el.dataset.name);
            updateCategory.find('[name=slug]').val(el.dataset.slug);
            
            $('#updateCategory').modal('show');
        }

        var deleteCategory = el => {
            $('#deleteConf form').attr('action', '{{ url('/admin/category') }}/' + el.dataset.id);
            $('#deleteConf').modal('show');
        };
    </script>
@endpush