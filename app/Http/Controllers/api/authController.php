<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Doctor;

class authController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'mobile' => 'required|string',
            'password' => 'required|string',
        ]);

        $doctor = Doctor::where('mobile', $request->mobile)->first();

        if (! $doctor || ! Hash::check($request->password, $doctor->password)) {
            return response()->json(['message' => 'اطلاعات وارد شده صحیح نیست'], 401);
        }

        $token = $doctor->createToken('mobile')->plainTextToken;

        return response()->json([
            'message'=>'با موفقیت وارد شدید',
            'doctor' => $doctor,
            'token' => $token,
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'با موفقیت خارج شدید']);
    }
}
