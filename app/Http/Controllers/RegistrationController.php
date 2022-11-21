<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;


class RegistrationController extends Controller
{
    function register(Request $request){
        if (Auth::check()) {
            return redirect(route('user.profile'));
        }
        $validateFields = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
        $id = uniqid();
        $validateFields = array('id' => $id) + $validateFields;
        $user = User::create($validateFields);
        if ($user) {
            Auth::login($user, $request->remember);
            $json = json_encode(array('language' => "ru"));
            Redis::set($user->id, $json);
            return redirect(route('user.profile'));
        } else {
            return redirect(route('user.login'))->withErrors([
                'formError' => 'Ошибка при аутентификации'
            ]);
        }
    }
}
