<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // اضافه کردن Rule برای اعتبارسنجی
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    // نمایش پروفایل کاربر
    public function showProfile()
    {
        $user = Auth::user(); // استفاده از Auth::user() با حرف کوچک
        return view('Panel.User.profile', compact('user'));
    }

    // نمایش فرم ویرایش پروفایل
    public function editProfile()
    {
        $user = Auth::user(); // استفاده از Auth::user() با حرف کوچک
        return view('Panel.User.editUser', compact('user'));
    }

    // بروزرسانی پروفایل
    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // استفاده از Auth::user() با حرف کوچک

        // بررسی وجود کاربر
        if (!$user) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد شوید.');
        }

        // اعتبارسنجی داده‌ها
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:15'],
            'current_password' => ['nullable', 'string', 'min:8'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // بروزرسانی اطلاعات پایه
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // بروزرسانی رمز عبور در صورت ارائه
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
            } else {
                return redirect()->back()->withErrors(['current_password' => 'رمز عبور فعلی نادرست است.']);
            }
        }

        // ذخیره تغییرات
        $user->save();

        // نمایش پیام موفقیت
        Alert::success('موفقیت', 'پروفایل شما با موفقیت بروزرسانی شد.');
        return redirect()->route('profile');
    }
}
