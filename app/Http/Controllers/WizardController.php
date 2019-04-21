<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WizardController extends Controller
{
    public function index()
    {
        abort_if(\App\SiteSetting::count(), 503);

        $data = [
            'title' => 'Welcome to Setup Wizard!',
        ];

        return view('wizard', $data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'site_name' => 'required',
            'site_description' => 'required',
            'show_at_most' => 'required|numeric|min:1',
            'popular_at_most' => 'required|numeric|min:1',
            'snippet_length' => 'required|numeric',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        \App\SiteSetting::create([
            'name' => $validatedData['site_name'],
            'description' => $validatedData['site_description'],
            'show_at_most' => $validatedData['show_at_most'],
            'popular_at_most' => $validatedData['popular_at_most'],
            'snippet_length' => $validatedData['snippet_length'],
        ]);

        \App\User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'is_admin' => 1,
            'password' => password_hash($validatedData['password'], PASSWORD_DEFAULT),
        ]);

        return redirect('/login')->with('info', 'Setup Success. You can now login with the form below :)');
    }
}
