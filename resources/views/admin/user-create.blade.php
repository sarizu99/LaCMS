@extends('layouts.admin')

@section('title', $title)
    
@section('content')
    <div class="row">
        <div class="col-md-8 my-4">
            <form action="{{ url()->current() }}" method="post">
                @csrf
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td width="200">
                                <label for="Name">Name</label>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="name" id="Name" placeholder="e.g. John Doe"  value="{{ old('name') }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="Email">Email</label>
                            </td>
                            <td>
                                <input type="email" class="form-control" name="email" id="Email" placeholder="e.g. johndoe@example.com"  value="{{ old('email') }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="Password">Password</label>
                            </td>
                            <td>
                                <input type="password" class="form-control" name="password" id="Password">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="PasswordC">Password Confirmation</label>
                            </td>
                            <td>
                                <input type="password" class="form-control" name="password_confirmation" id="PasswordC">
                                <p class="form-text text-muted">
                                    Re-enter the password
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button class="btn btn-primary float-right" type="submit">Create</button>
            </form>
        </div>
    </div>
@endsection