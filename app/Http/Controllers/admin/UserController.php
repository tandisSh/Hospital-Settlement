<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        return view('admin.User.profile', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('admin.User.editUser', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'لطفاً ابتدا وارد شوید.');
        }

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:15'],
            'current_password' => ['nullable', 'string', 'min:6'],
            'new_password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        try {
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->phone = $validatedData['phone'];

            if ($request->filled('current_password') && $request->filled('new_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['current_password' => 'رمز عبور فعلی نادرست است.']);
                }
                $user->password = Hash::make($request->new_password);
            }

            $user->save();

            Alert::success('موفق!', 'اطلاعات با موفقیت بروزرسانی شد.');
            return redirect()->route('profile');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'خطایی در بروزرسانی پروفایل رخ داد. لطفاً دوباره تلاش کنید.');
        }
    }
}
