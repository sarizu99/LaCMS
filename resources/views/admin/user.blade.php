@extends('layouts.admin')

@section('title', $title)

@section('content')
    <div class="row">
        <div class="col-md-12">
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

            <a class="btn btn-primary mb-3" href="{{ url('/admin/users/create') }}"><i class="fas fa-plus mr-2"></i> New User</a>
            
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Posts</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <div class="user-name">
                                    @if ($user->name == Auth::user()->name)
                                        <span title="This is You :)" class="badge badge-warning mr-1" style="cursor:help"><i class="fas fa-star text-white"></i></span>
                                    @endif
                                    {{ $user->name }}
                                    <div class="show-hover user-action">
                                        <button class="btn btn-sm btn-outline-secondary"
                                            onclick="updateUser(this)"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-role="{{ $user->is_admin }}"
                                            data-email="{{ $user->email }}">Edit
                                        </button>
                                        @unless ($user->id == Auth::user()->id)
                                            <button class="btn btn-sm btn-danger"
                                                onclick="deleteUser(this)"
                                                data-id="{{ $user->id }}">Delete</button>
                                        @endunless
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->is_admin)
                                    Admin
                                @else
                                    Author
                                @endif
                            </td>
                            <td>{{ $user->posts->count() }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Posts</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="modal fade" id="updateUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <form action="" method="post">
            @csrf
            @method('put')
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update user</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="align-middle">
                                        <label class="mb-0" for="Name">Name</label>
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" name="name" id="Name">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">
                                        <label class="mb-0" for="Email">Email</label>
                                    </td>
                                    <td>
                                        <input class="form-control" type="email" name="email" id="Email">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">
                                        <label class="mb-0" for="Role">Role</label>
                                    </td>
                                    <td>
                                        <select class="form-control" name="is_admin" id="Role">
                                            <option value="1">Admin</option>
                                            <option value="0">Author</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <form action="" method="post">
            @csrf
            @method('delete')
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this user?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        var updateUser = e => {
            var modal = $('#updateUser');

            modal.find('form').attr("action", "{{ url('/admin/users') }}/" + e.dataset.id);
            modal.find('#Name').val(e.dataset.name);
            modal.find('#Email').val(e.dataset.email);

            if (e.dataset.role == 1) {
                modal.find('[value=1]').attr("selected", "");
            } else {
                modal.find('[value=0]').attr("selected", "");
            }

            modal.modal();
        }
        
        var deleteUser = e => {
            var modal = $('#deleteUser');

            modal.find('form').attr("action", "{{ url('/admin/users') }}/" + e.dataset.id);

            modal.modal();
        }
    </script>
@endpush