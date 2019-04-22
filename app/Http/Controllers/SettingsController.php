<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function basicIndex()
    {
        $data = [
            'title' => 'General Settings',
            'site'  => \App\SiteSetting::first(),
        ];

        return view('admin/settings-basic', $data);
    }

    public function accountIndex()
    {
        $data = [
            'title' => 'Account Settings',
            'user'  => Auth::user(),
        ];

        return view('admin/settings-account', $data);
    }

    public function updateBasic(Request $request)
    {
        $request->validate([
            'name'           => 'required|max:190',
            'snippet_length' => 'required|min:0',
            'description'    => 'required',
            'show_at_most'   => 'required',
            'popular_at_most'=> 'required',
        ]);

        $name           = $request->input('name');
        $snippet_length = $request->input('snippet_length');
        $description    = $request->input('description');
        $show_at_most   = $request->input('show_at_most');
        $popular_at_most= $request->input('popular_at_most');

        \App\SiteSetting::first()->update([
            'name'              => $name,
            'snippet_length'      => $snippet_length,
            'description'       => $description,
            'show_at_most'      => $show_at_most,
            'popular_at_most'   => $popular_at_most,
        ]);

        return redirect(url()->previous())->with('success', 'Settings updated');
    }
}
