<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Insurance;
use App\Models\Operation;
use App\Models\Surgery;
use App\Models\DoctorRole;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class SurgeryController extends Controller
{
    public function List()
    {
        $surgeries = Surgery::with(['basicInsurance', 'suppInsurance', 'doctors', 'operations'])->orderBy('created_at', 'desc')->get();
        return view('Panel.surgery.List', compact('surgeries'));
    }
    public function create()
    {
        $insurances = Insurance::all();
        $surgeons = Doctor::whereHas('roles', function($query) {
            $query->where('doctor_role_id', 1); // جراح
        })->get();
        $anesthesiologists = Doctor::whereHas('roles', function($query) {
            $query->where('doctor_role_id', 2); // بیهوشی
        })->get();
        $consultants = Doctor::whereHas('roles', function($query) {
            $query->where('doctor_role_id', 3); // مشاور
        })->get();
        $operations = Operation::all();
        $today = Carbon::now()->format('Y/m/d');

        return view('Panel.surgery.create', compact('insurances', 'surgeons', 'anesthesiologists', 'consultants', 'operations', 'today'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:100',
            'patient_national_code' => 'required|string|max:20',
            'basic_insurance_id' => 'nullable|exists:insurances,id',
            'supp_insurance_id' => 'nullable|exists:insurances,id',
            'document_number' => 'required|unique:surgeries,document_number',
            'surgeried_at' => 'required|date',
            'released_at' => 'required|date|after_or_equal:surgeried_at',
            'surgeon_doctor_id' => 'required|exists:doctors,id',
            'anesthesiologist_doctor_id' => 'required|exists:doctors,id|different:surgeon_doctor_id',
            'consultant_doctor_id' => 'nullable|exists:doctors,id|different:surgeon_doctor_id|different:anesthesiologist_doctor_id',
            'surgery_types' => 'required|array',
            'surgery_types.*' => 'exists:operations,id',
            'description' => 'nullable|string',
        ]);

        $surgery = Surgery::create([
            'patient_name' => $request->patient_name,
            'patient_national_code' => $request->patient_national_code,
            'basic_insurance_id' => $request->basic_insurance_id,
            'supp_insurance_id' => $request->supp_insurance_id,
            'document_number' => $request->document_number,
            'surgeried_at' => $request->surgeried_at,
            'released_at' => $request->released_at,
            'description' => $request->description,
        ]);

        // محاسبه مجموع هزینه‌های عمل‌ها
        $operations = Operation::whereIn('id', $request->surgery_types)->get();
        $totalCost = $operations->sum('price');

        // Get doctor roles with their shares
        $doctorRoles = DoctorRole::whereIn('id', [1, 2, 3])->pluck('quota', 'id');

        // Calculate shares based on surgery cost
        $surgeonShare = $doctorRoles[1];
        $anesthesiologistShare = $doctorRoles[2];
        $consultantShare = $doctorRoles[3] ?? 0;

        // اگر مشاور نداشته باشیم، سهم مشاور به جراح اضافه می‌شود
        if (!$request->consultant_doctor_id) {
            $surgeonShare += $consultantShare;
            $consultantShare = 0;
        }

        // محاسبه مبلغ هر پزشک
        $doctors = [
            2 => [
                'id' => $request->surgeon_doctor_id,
                'amount' => ($surgeonShare / 100) * $totalCost
            ],
            1 => [
                'id' => $request->anesthesiologist_doctor_id,
                'amount' => ($anesthesiologistShare / 100) * $totalCost
            ]
        ];

        if ($request->consultant_doctor_id) {
            $doctors[3] = [
                'id' => $request->consultant_doctor_id,
                'amount' => ($consultantShare / 100) * $totalCost
            ];
        }

        $now = now();

        // اتصال پزشکان به جراحی با مقادیر محاسبه شده
        foreach ($doctors as $roleId => $doctor) {
            DB::table('surgery_doctor')->insert([
                'surgery_id' => $surgery->id,
                'doctor_id' => $doctor['id'],
                'doctor_role_id' => $roleId,
                'amount' => $doctor['amount'],
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }

        // ذخیره عمل‌های جراحی با مبالغ مربوطه
        foreach ($operations as $operation) {
            DB::table('surgery_operation')->insert([
                'surgery_id' => $surgery->id,
                'operation_id' => $operation->id,
                'amount' => $operation->price,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }

        Alert::success('موفق!', 'عمل جراحی با موفقیت ثبت شد.');
        return redirect()->route('surgeries');
    }

    public function edit($id)
    {
        $surgery = Surgery::findOrFail($id);
        $surgeried_at = Carbon::parse($surgery->surgeried_at)->format('Y/m/d');
        $released_at = $surgery->released_at ? Carbon::parse($surgery->released_at)->format('Y/m/d') : null;
        $insurances = Insurance::all();
        $surgeons = Doctor::whereHas('roles', function($query) {
            $query->where('doctor_role_id', 1); // جراح
        })->get();
        $anesthesiologists = Doctor::whereHas('roles', function($query) {
            $query->where('doctor_role_id', 2); // بیهوشی
        })->get();
        $consultants = Doctor::whereHas('roles', function($query) {
            $query->where('doctor_role_id', 3); // مشاور
        })->get();
        $operations = Operation::all();

        return view('Panel.Surgery.Edit', compact('surgery', 'insurances', 'surgeons', 'anesthesiologists', 'consultants', 'operations', 'surgeried_at', 'released_at'));
    }
    public function update(Request $request, $id)
    {
        $surgery = Surgery::findOrFail($id);

        $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_national_code' => 'required|string|size:10',
            'basic_insurance_id' => 'required|exists:insurances,id',
            'supp_insurance_id' => 'nullable|exists:insurances,id',
            'document_number' => 'required|numeric',
            'description' => 'nullable|string',
            'surgeon_doctor_id' => 'required|exists:doctors,id',
            'anesthesiologist_doctor_id' => 'required|exists:doctors,id|different:surgeon_doctor_id',
            'consultant_doctor_id' => 'nullable|exists:doctors,id|different:surgeon_doctor_id|different:anesthesiologist_doctor_id',
            'surgery_types' => 'required|array',
            'surgery_types.*' => 'exists:operations,id',
            'surgeried_at' => 'required|date',
            'released_at' => 'required|date|after_or_equal:surgeried_at',
        ]);

        $surgery->update([
            'patient_name' => $request->patient_name,
            'patient_national_code' => $request->patient_national_code,
            'basic_insurance_id' => $request->basic_insurance_id,
            'supp_insurance_id' => $request->supp_insurance_id,
            'document_number' => $request->document_number,
            'description' => $request->description,
            'surgeried_at' => $request->surgeried_at,
            'released_at' => $request->released_at,
        ]);

        // محاسبه مجموع هزینه‌های عمل‌ها
        $operations = Operation::whereIn('id', $request->surgery_types)->get();
        $totalCost = $operations->sum('price');

        // Get doctor roles with their shares
        $doctorRoles = DoctorRole::whereIn('id', [1, 2, 3])->pluck('quota', 'id');

        // Calculate shares based on surgery cost
        $surgeonShare = $doctorRoles[1]; // سهم جراح
        $anesthesiologistShare = $doctorRoles[2]; // سهم متخصص بیهوشی
        $consultantShare = $doctorRoles[3] ?? 0; // سهم مشاور

        // اگر مشاور نداشته باشیم، سهم مشاور به جراح اضافه می‌شود
        if (!$request->consultant_doctor_id) {
            $surgeonShare += $consultantShare;
            $consultantShare = 0;
        }

        // محاسبه مبلغ هر پزشک
        $doctors = [
            1 => [
                'id' => $request->surgeon_doctor_id,
                'amount' => ($surgeonShare / 100) * $totalCost
            ],
            2 => [
                'id' => $request->anesthesiologist_doctor_id,
                'amount' => ($anesthesiologistShare / 100) * $totalCost
            ]
        ];

        if ($request->consultant_doctor_id) {
            $doctors[3] = [
                'id' => $request->consultant_doctor_id,
                'amount' => ($consultantShare / 100) * $totalCost
            ];
        }

        $now = now();

        // Sync doctors with their roles and amounts
        $doctorSync = [];
        foreach ($doctors as $roleId => $doctor) {
            $doctorSync[$doctor['id']] = [
                'doctor_role_id' => $roleId,
                'amount' => $doctor['amount'],
                'updated_at' => $now
            ];
        }
        $surgery->doctors()->sync($doctorSync);

        // Sync operations with amounts
        $operationSync = [];
        foreach ($operations as $operation) {
            $operationSync[$operation->id] = [
                'amount' => $operation->price,
                'updated_at' => $now
            ];
        }
        $surgery->operations()->sync($operationSync);

        Alert::success('موفق!', 'اطلاعات عمل جراحی با موفقیت بروزرسانی شد.');
        return redirect()->route('surgeries');
    }
    public function delete($id)
    {
        $surgery = Surgery::findOrFail($id);
        $surgery->delete();
        return redirect()->route('surgeries')->with('success', 'عمل جراحی حذف شد.');
    }
    public function show($id)
    {
        $surgery = Surgery::with(['basicInsurance', 'suppInsurance', 'doctors.speciality', 'operations'])->findOrFail($id);
        return view('Panel.Surgery.Show', compact('surgery'));
    }
}
