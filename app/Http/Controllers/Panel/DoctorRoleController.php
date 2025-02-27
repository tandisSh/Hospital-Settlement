<?php
namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\DoctorRole;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DoctorRoleController extends Controller
{
    public function List()
    {
        $roles = DoctorRole::orderBy('created_at', 'desc')->get();
        return view('Panel.DoctorRole.DoctorRoleList', compact('roles'));
    }
    public function Create()
    {
        return view('Panel.DoctorRole.CreateDoctorRole');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191|unique:doctor_roles,title',
            'required' => 'boolean',
            'quota' => 'required|integer|min:1|max:100',
            'status' => 'boolean',
        ]);

        DoctorRole::create($request->all());

        Alert::success('موفق!', 'نقش جدید با موفقیت اضافه شد.');
        return redirect()->route('Show.DoctorRole');
    }
    public function edit($id)
    {
        $role = DoctorRole::findOrFail($id);
        return view('Panel.DoctorRole.EditDoctorRole', compact('role'));
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
