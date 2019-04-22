@extends('layouts.admin')

@section('title', $title)

@section('content')
    <div class="row my-4">
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
                    $(".alert").alert();
                </script>
            @endif

            @if (session('danger'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong>{{ session('danger') }}</strong> 
                </div>
            
                <script>
                    $(".alert").alert();
                </script>
            @endif

            <form action="{{ url('/admin/settings/account') }}" method="post">
                @csrf
                @method('put')
                <h4>Basic</h4>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td width="200">
                                <label for="Name">Name</label>
                            </td>
                            <td>
                                <input type="text" name="name" id="Name" class="form-control" value="{{ $user->name }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="email">Email</label>
                            </td>
                            <td>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h4>Privacy</h4>
                <p class="form-text text-danger">
                    Fill the fields below only if you want to change your password!
                </p>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td width="200">
                                <label for="OldPassword">Current Password</label>
                            </td>
                            <td>
                                <input type="password" name="old_password" id="OldPassword" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="NewPassword">New Password</label>
                            </td>
                            <td>
                                <input type="password" name="new_password" id="NewPassword" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="NewPasswordC">Confirm Password</label>
                            </td>
                            <td>
                                <input type="password" name="new_password_c" id="NewPasswordC" class="form-control">
                                <p class="form-text text-muted">
                                    Re-enter your new password
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button class="float-right btn btn-primary" type="submit">Update</button>
            </form>
        </div>
    </div>
@endsection