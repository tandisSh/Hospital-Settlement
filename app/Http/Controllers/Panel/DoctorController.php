<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Speciality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class DoctorController extends Controller
{
    public function List()
    {
        $doctors = Doctor::with('speciality')->orderBy('created_at', 'desc')->get();
        return view('Panel.Doctor.List', compact('doctors'));
    }

    public function Show($id)
    {
        $doctor = Doctor::with(['speciality', 'roles'])->findOrFail($id);
        return view('Panel.Doctor.Show', compact('doctor'));
    }

    public function Create()
    {
        $specialities = Speciality::all();
        return view('Panel.Doctor.Create', compact('specialities'));
    }
    
    public function Store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'speciality_id' => 'required|exists:specialities,id',
            'national_code' => 'required|string|max:10',
            'medical_number' => 'required|string|max:191',
            'mobile' => 'required|string|max:11|unique:doctors,mobile',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
            'status' => 'boolean',
        ], [
            'password.confirmed' => 'رمز عبور و تکرار آن باید یکسان باشند.',
            'password_confirmation.required' => 'تکرار رمز عبور الزامی است.',
        ]);

        $doctor = Doctor::create([
            'name' => $request->name,
            'speciality_id' => $request->speciality_id,
            'national_code' => $request->national_code,
            'medical_number' => $request->medical_number,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'status' => $request->status ?? 1,
        ]);

        Alert::success('موفق!', 'پزشک جدید با موفقیت اضافه شد.');
        return redirect()->route('Doctors');
    }
    
    public function Edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        $specialities = Speciality::where('status', 1)->get();
        return view('Panel.Doctor.Edit', compact('doctor', 'specialities'));
    }

    public function Update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:100',
            'speciality_id' => 'required|exists:specialities,id',
            'national_code' => 'required|string|max:10',
            'medical_number' => 'required|string|max:191',
            'mobile' => 'required|string|max:11|unique:doctors,mobile,' . $id,
            'status' => 'boolean',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6|confirmed';
            $rules['password_confirmation'] = 'required';
        }

        $request->validate($rules, [
            'password.confirmed' => 'رمز عبور و تکرار آن باید یکسان باشند.',
            'password_confirmation.required' => 'تکرار رمز عبور الزامی است.',
        ]);

        $data = $request->except(['password', 'password_confirmation']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $doctor->update($data);

        Alert::success('موفق!', 'پزشک با موفقیت ویرایش شد.');
        return redirect()->route('Doctors');
    }
    
    public function delete($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return redirect()->route('Doctors')->with('success', 'پزشک با موفقیت حذف شد.');
    }
}
