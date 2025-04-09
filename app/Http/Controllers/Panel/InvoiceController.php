<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorRole;
use App\Models\Invoice;
use App\Models\Surgery;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{

    public function invoiceList()
    {
        $user = Auth::user();
        $invoices = Invoice::orderBy('created_at', 'desc')->get();
        return view('Panel.Invoice.List', compact('invoices', 'user'));
    }
    public function index()
    {
        $user = Auth::user();
        $invoices = Invoice::all();
        return view('Panel.Invoice.List', compact('invoices', 'user'));
    }
    public function pay()
    {
        $user = Auth::user();
        $doctors = Doctor::orderBy('name')->get();
        return view('Panel.Invoice.Create', compact('user', 'doctors'));
    }
    public function searchPay(Request $request)
    {
        $user = Auth::user();
        $doctors = Doctor::orderBy('name')->get();

        if ($request->has('doctor_id') && $request->doctor_id) {
            $doctor = Doctor::with(['roles', 'speciality'])->findOrFail($request->doctor_id);

            // تبدیل تاریخ‌های شمسی به میلادی
            $startDate = $request->start_date ? Jalalian::fromFormat('Y/m/d', $request->start_date)->toCarbon() : null;
            $endDate = $request->end_date ? Jalalian::fromFormat('Y/m/d', $request->end_date)->toCarbon() : null;


            $surgeries = Surgery::with(['doctors', 'operations'])
                ->whereHas('doctors', function ($query) use ($request) {
                    $query->where('doctors.id', $request->doctor_id)
                        ->whereNull('surgery_doctor.invoice_id');
                })
                ->when($startDate, function ($query) use ($startDate) {
                    $query->where('surgeried_at', '>=', $startDate);
                })
                ->when($endDate, function ($query) use ($endDate) {
                    $query->where('surgeried_at', '<=', $endDate);
                })
                ->get()
                ->map(function ($surgery) use ($doctor) {
                    $doctorSurgery = $surgery->doctors->where('id', $doctor->id)->first();

                    $roleName = 'تعیین نشده';
                    $amount = 0;

                    if ($doctorSurgery) {
                        $amount = $doctorSurgery->pivot->amount ?? 0;

                        if ($doctorSurgery->pivot->doctor_role_id) {
                            $role = DoctorRole::find($doctorSurgery->pivot->doctor_role_id);
                            if ($role) {
                                $roleName = $role->title;
                            }
                        }
                    }

                    return [
                        'id' => $surgery->id,
                        'patient_name' => $surgery->patient_name,
                        'operations' => $surgery->operations,
                        'role_name' => $roleName,
                        'amount' => $amount,
                        'surgeried_at' => $surgery->surgeried_at
                    ];
                });


            $showSurgeryList = $doctor && $surgeries->isNotEmpty();
            $totalAmount = $surgeries->sum('amount');

            return view('Panel.Invoice.Create', compact('doctor', 'user', 'surgeries', 'doctors', 'showSurgeryList', 'totalAmount'));
        }

        return view('Panel.Invoice.Create', compact('user', 'doctors'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'surgery_ids' => 'required|array|min:1',
            'surgery_ids.*' => 'exists:surgeries,id',
            'selected_total_amount' => 'required|numeric|min:0'
        ]);

        if (!$request->has('surgery_ids') || empty($request->surgery_ids)) {
            Alert::error('خطا', 'لطفا حداقل یک عمل را انتخاب کنید');
            return redirect()->back();
        }

        $surgeries = Surgery::with(['doctors'])->whereIn('id', $request->surgery_ids)->get();

        if ($surgeries->isEmpty()) {
            Alert::error('خطا', 'عملیات انتخاب شده یافت نشد');
            return redirect()->back();
        }

        $invoice = Invoice::create([
            'doctor_id' => $request->doctor_id,
            'amount' => $request->selected_total_amount,
            'status' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        foreach ($surgeries as $surgery) {
            $surgery->doctors()->updateExistingPivot($request->doctor_id, [
                'invoice_id' => $invoice->id
            ]);
        }

        Alert::success('موفقیت', 'صورتحساب با موفقیت ایجاد شد');
        return redirect()->route('Panel.Invoice.List');
    }
    public function destroy($invoiceId)
    {
        // یافتن فاکتور با توجه به ID
        $invoice = Invoice::findOrFail($invoiceId);

        // بررسی اینکه آیا فاکتور قابل حذف است یا نه
        if ($invoice->status != 0) {
            // در صورتی که وضعیت فاکتور قابل حذف نباشد
            Alert::error('خطا', 'این فاکتور قابل حذف نیست');
            return redirect()->back();
        }

        // شروع تراکنش برای اطمینان از عدم وقوع خطا
        DB::beginTransaction();

        try {
            // حذف فاکتور
            $invoice->delete();

            // بروزرسانی جدول `surgery_doctor` و ست کردن `invoice_id` به `null`
            foreach ($invoice->surgeries as $surgery) {
                foreach ($surgery->doctors as $doctor) {
                    $doctor->pivot->update(['invoice_id' => null]);
                }
            }

            // تایید تراکنش
            DB::commit();

            // نمایش پیام موفقیت
            Alert::success('موفقیت', 'فاکتور با موفقیت حذف شد');
            return redirect()->route('Panel.Invoice.List');
        } catch (\Exception $e) {
            // در صورتی که خطایی رخ دهد، تراکنش برگشت می‌خورد
            DB::rollBack();

            // نمایش پیام خطا
            Alert::error('خطا', 'خطایی در حذف فاکتور رخ داده است: ' . $e->getMessage());
            return redirect()->back();
        }
    }
    public function print($id)
    {
        $invoice = Invoice::with('doctor')->findOrFail($id);

        $surgeryData = DB::table('surgery_doctor')
            ->where('surgery_doctor.invoice_id', $id)
            ->join('surgeries', 'surgery_doctor.surgery_id', '=', 'surgeries.id')
            ->join('surgery_operation', 'surgeries.id', '=', 'surgery_operation.surgery_id')
            ->join('operations', 'surgery_operation.operation_id', '=', 'operations.id')
            ->select(
                'surgeries.id as surgery_id',
                'surgeries.patient_name',
                'operations.name as operation_name',
                'surgeries.surgeried_at',
                'surgeries.released_at',
                'surgery_doctor.amount' // نام فیلد را تغییر ندادیم
            )
            ->get();

        return view('Panel.Invoice.print', [
            'invoice' => $invoice,
            'surgeryData' => $surgeryData
        ]);
    }
}
