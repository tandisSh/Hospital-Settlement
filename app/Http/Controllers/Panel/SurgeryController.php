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
        $doctors = Doctor::all();
        $operations = Operation::all();
        $today = Carbon::now()->format('Y/m/d');
        return view('Panel.surgery.create', compact('insurances', 'doctors', 'operations', 'today'));
    }
    public function store(Request $request)
    {
        // تبدیل تاریخ‌های شمسی به میلادی
        $request->merge([
            'surgeried_at' => Carbon::parse($request->surgeried_at)->toDateTimeString(),
            'released_at' => Carbon::parse($request->released_at)->toDateTimeString(),
        ]);

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
            'surgery_type' => 'required|exists:operations,id',
            'cost' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        // Create surgery record
        $surgery = Surgery::create([
            'patient_name' => $request->patient_name,
            'patient_national_code' => $request->patient_national_code,
            'basic_insurance_id' => $request->basic_insurance_id,
            'supp_insurance_id' => $request->supp_insurance_id,
            'document_number' => $request->document_number,
            'surgeried_at' => $request->surgeried_at,
            'released_at' => $request->released_at,
            'cost' => $request->cost,
            'description' => $request->description,
        ]);

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
        $totalCost = $request->cost;
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

        // اتصال پزشکان به جراحی با مقادیر محاسبه شده
        foreach ($doctors as $roleId => $doctor) {
            $surgery->doctors()->attach($doctor['id'], [
                'doctor_role_id' => $roleId,
                'amount' => $doctor['amount'],
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }

        // Get operation cost
        $operation = Operation::find($request->surgery_type);
        $operationAmount = $operation ? $operation->cost : 0;

        // Attach operation type with amount and timestamps
        $surgery->operations()->attach($request->surgery_type, [
            'amount' => $operationAmount,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        Alert::success('موفق!', 'عمل جراحی با موفقیت ثبت شد.');
        return redirect()->route('surgeries')->with('success', 'عمل جراحی با موفقیت ثبت شد.');
    }
    public function edit(Surgery $surgery)
    {
        $surgeried_at = Carbon::parse($surgery->surgeried_at)->format('Y/m/d');
        $released_at = $surgery->released_at ? Carbon::parse($surgery->released_at)->format('Y/m/d') : null;
        $insurances = Insurance::all();
        $doctors = Doctor::all();
        $operations = Operation::all();
        
        return view('Panel.surgery.edit', compact('surgery', 'insurances', 'doctors', 'operations', 'surgeried_at', 'released_at'));
    }
    public function update(Request $request, $id)
    {
        // تبدیل تاریخ‌های شمسی به میلادی
        $request->merge([
            'surgeried_at' => Carbon::parse($request->surgeried_at)->toDateTimeString(),
            'released_at' => Carbon::parse($request->released_at)->toDateTimeString(),
        ]);

        $surgery = Surgery::findOrFail($id);

        $request->validate([
            'patient_name' => 'required|string|max:100',
            'patient_national_code' => 'required|string|max:20',
            'basic_insurance_id' => 'nullable|exists:insurances,id',
            'supp_insurance_id' => 'nullable|exists:insurances,id',
            'document_number' => 'required|unique:surgeries,document_number,' . $id,
            'surgeried_at' => 'required|date',
            'released_at' => 'required|date|after_or_equal:surgeried_at',
            'surgeon_doctor_id' => 'required|exists:doctors,id',
            'anesthesiologist_doctor_id' => 'required|exists:doctors,id|different:surgeon_doctor_id',
            'consultant_doctor_id' => 'nullable|exists:doctors,id|different:surgeon_doctor_id|different:anesthesiologist_doctor_id',
            'surgery_type' => 'required|exists:operations,id',
            'cost' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        // Update surgery record
        $surgery->update([
            'patient_name' => $request->patient_name,
            'patient_national_code' => $request->patient_national_code,
            'basic_insurance_id' => $request->basic_insurance_id,
            'supp_insurance_id' => $request->supp_insurance_id,
            'document_number' => $request->document_number,
            'surgeried_at' => $request->surgeried_at,
            'released_at' => $request->released_at,
            'cost' => $request->cost,
            'description' => $request->description,
        ]);

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
        $totalCost = $request->cost;
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

        // Get operation cost
        $operation = Operation::find($request->surgery_type);
        $operationAmount = $operation ? $operation->cost : 0;

        // Sync operation with amount and timestamp
        $surgery->operations()->sync([
            $request->surgery_type => [
                'amount' => $operationAmount,
                'updated_at' => $now
            ]
        ]);

        Alert::success('موفق!', 'اطلاعات عمل جراحی با موفقیت بروزرسانی شد.');
        return redirect()->route('surgeries')->with('success', 'اطلاعات عمل جراحی با موفقیت بروزرسانی شد.');
    }
    public function delete($id)
    {
        $surgery = Surgery::findOrFail($id);
        $surgery->delete();
        return redirect()->route('surgeries')->with('success', 'عمل جراحی حذف شد.');
    }
}
