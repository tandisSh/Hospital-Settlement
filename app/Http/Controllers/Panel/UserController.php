<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function Users()
    {
        $users = User::all();
        return view('Panel.User.UsersList', compact('users'));
    }
    public function Create()
    {
        return view('Panel.User.CreateUser');
    }
    public function Store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "phone" => "required",
            "email" => "required|email",
            "password" => "required|min:6",
        ]);

        $UserPhone = User::where("phone", $request->phone)->first();

        if (!$UserPhone) {
            $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Alert::success('موفق!', 'کاربر با موفقیت ثبت شد.');
            return redirect()->route("Show.Users");
        } else {
            Alert::error('خطا!', "شماره تلفن از قبل وجود دارد.");
            return redirect()->route("User.Create.Form");
        }
    }
    public function EditUser($id)
    {
        $user = User::find($id);
        return view('Panel.User.EditUser', compact('user'));
    }
    public function UpdateUser(Request $request, $id)
    {
        $user = User::find($id);
        $dataform = $request->all();
        $user->update($dataform);

        Alert::success('موفق!', 'کاربر با موفقیت ویرایش شد.');
        return redirect()->route('Show.Users');
    }
    public function DeleteUser(Request $request, $id)
    {
        $user = User::find($id);

        $user->delete();
        // Alert::success('موفق!', 'کاربر با موفقیت حذف شد.');
        return redirect()->route('Show.Users')->with('success', 'کاربر با موفقیت حذف شد.');
    }
}
