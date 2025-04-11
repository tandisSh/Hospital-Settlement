<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorRole;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DoctorRoleController extends Controller
{
    public function List()
    {
        $roles = DoctorRole::orderBy('created_at', 'desc')->get();
        return view('admin.DoctorRole.DoctorRoleList', compact('roles'));
    }
    public function Create()
    {
        return view('admin.DoctorRole.CreateDoctorRole');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191|unique:doctor_roles,title',
            'required' => 'boolean',
            'quota' => 'required|integer|min:1|max:100',
            'status' => 'boolean',
        ]);

        //  مجموع درصد سهمیه‌ها
        $totalQuota = DoctorRole::sum('quota');
        // درصد ها بیشتر از صد نشه
        if ($totalQuota + $request->quota > 100) {
            return back()->withInput()->withErrors(['quota' => 'مجموع درصد سهمیه‌ها نمی‌تواند از 100 بیشتر باشد. (مجموع فعلی: ' . $totalQuota . '%)']);
        }

        DoctorRole::create($request->all());

        Alert::success('موفق!', 'نقش جدید با موفقیت اضافه شد.');
        return redirect()->route('Show.DoctorRole');
    }
    public function edit($id)
    {
        $role = DoctorRole::findOrFail($id);
        return view('admin.DoctorRole.EditDoctorRole', compact('role'));
    }
    public function update(Request $request, $id)
    {
        $role = DoctorRole::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:191|unique:doctor_roles,title,' . $id,
            'required' => 'boolean',
            'quota' => 'required|integer|min:1|max:100',
            'status' => 'boolean',
        ]);

        // محاسبه مجموع درصد سهمیه‌های موجود به جز سهمیه فعلی
        $totalQuota = DoctorRole::where('id', '!=', $id)->sum('quota');

        // بررسی اینکه با تغییر سهمیه، مجموع از 100 بیشتر نشود
        if ($totalQuota + $request->quota > 100) {
            return back()->withInput()->withErrors(['quota' => 'مجموع درصد سهمیه‌ها نمی‌تواند از 100 بیشتر باشد. (مجموع فعلی بدون این نقش: ' . $totalQuota . '%)']);
        }

        $role->update($request->all());

        Alert::success('موفق!', 'نقش با موفقیت ویرایش شد.');
        return redirect()->route('Show.DoctorRole');
    }
    public function Delete($id)
    {
        $role = DoctorRole::findOrFail($id);
        $role->delete();

        return redirect()->route('Show.DoctorRole')->with('success', 'کاربر با موفقیت حذف شد.');
    }
}
