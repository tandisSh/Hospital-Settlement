<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function LoginForm()
    {
        return view("Auth.Login");
    }
    public function Login(Request $request)
    {
        $request->validate([
            "phone" => "required",
            "password" => "required",
        ]);

        $user = User::where("phone", $request->phone)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route("admin");
        } else {
            return redirect()->route("login")->with('error', trans('validation.auth.failed'));
        }
    }
}
