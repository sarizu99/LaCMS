<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Users',
            'users' => \App\User::all(),
        ];

        return view('admin/user', $data);
    }

    public function update(Request $request, $id)
    {
        $v = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'is_admin' => 'required',
        ]);

        \App\User::find($id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'is_admin' => $request->input('is_admin'),
        ]);

        return redirect('/admin/users')->with('success', 'User updated');
    }

    public function destroy($id)
    {
        \App\User::find($id)->delete();

        return redirect('/admin/users')->with('success', 'User deleted');
    }

    public function create()
    {
        $data = [
            'title' => 'Create User',
        ];

        return view('admin/user-create', $data);
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        \App\User::create([
            'name' => $v['name'],
            'email' => $v['email'],
            'is_admin' => 0,
            'password' => password_hash($v['password'], PASSWORD_DEFAULT),
        ]);

        return redirect('/admin/users')->with('success', 'User Created');
    }
}
