<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect(route('user.profile'));
        }
        $formFields = $request->only(['email', 'password']);
        $remember = $request->only(['remember']);
        if (Auth::attempt($formFields, (bool)$remember)) {
            return redirect(route('user.profile'));
        } else {
            return redirect(route('user.login'))->withErrors([
                'email' => 'Failed to authenticate'
            ]);
        }
    }
}
