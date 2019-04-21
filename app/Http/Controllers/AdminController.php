<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',

        ];

        return view('admin/post', $data);
    }

    public function updateAccount(Request $request)
    {
        $old_password = $request->input('old_password');
        $new_password = $request->input('new_password');
        $new_password_c = $request->input('new_password_c');

        $user = Auth::user();

        \App\User::find($user->id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        if (!empty($old_password)) {
            if (password_verify($old_password, \App\User::find($user->id)->password)) {
                if (!empty($new_password) && !empty($new_password_c)) {
                    if ($new_password == $new_password_c) {
                        \App\User::find($user->id)->update([
                            'password' => password_hash(
                                $new_password,
                                PASSWORD_DEFAULT
                            )
                        ]);

                        Auth::login(\App\User::find($user->id));

                        return redirect('/admin/settings/account')
                            ->with('success', 'Account updated');
                    } else {
                        return redirect('/admin/settings/account')
                            ->with(
                                'danger',
                                'Password change failed. Password confirmation didn\'t match.'
                            );
                    }
                } else {
                    return redirect('/admin/settings/account')
                        ->with(
                            'danger',
                            'Password change failed. Password and Confirmation is empty.'
                        );
                }
            } else {
                return redirect('/admin/settings/account')
                    ->with(
                        'danger',
                        'Password change failed. Current password is invalid.'
                    );
            }
        } else {
            return redirect('/admin/settings/account')
                ->with('success', 'Account updated');
        }
    }
}
