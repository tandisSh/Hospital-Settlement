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
        $doctors = Doctor::with('speciality')->get();
        return view('Panel.Doctor.List', compact('doctors'));
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
            'password' => 'required|string|min:6',
            'status' => 'boolean',
        ]);

        $DoctorPhone = Doctor::where("mobile", $request->mobile)->first();
        if (!$DoctorPhone) {
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
        } else {
            Alert::error('خطا!', "شماره تلفن از قبل وجود دارد.");
            return redirect()->route('Doctor.Create');
        }
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

        $data = $request->except('password');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $doctor->update($data);

        Alert::success('موفق!', 'پزشک  با موفقیت ویرایش شد.');
        return redirect()->route('Doctors');
    }
    public function delete($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return redirect()->route('Doctors')->with('success', 'پزشک با موفقیت حذف شد.');
    }
}
