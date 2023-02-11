<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function Anything(Request $request)
    {
        $credentials = $request->only('username', 'password');
        if (! $token = auth('web')->attempt($credentials)) {
            return response()->json(['User tidak sesuai'], 401);
        }
        $Data = User::where('username', $request->username)->first()->toArray();
        session($Data);
        return response()->json(['success']);
    }

    public function Logout()
    {
        \Session::flush();
        return Redirect::to('login');
    }
}
