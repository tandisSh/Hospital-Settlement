<?php

namespace App\Http\Controllers\admin;

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

    public function index()
    {
        $user = Auth::user();
        $invoices = Invoice::with('payments')->orderBy('created_at', 'desc')->get();
        return view('admin.Invoice.List', compact('invoices', 'user'));
    }
    public function pay()
    {
        $user = Auth::user();
        $doctors = Doctor::orderBy('name')->get();
        return view('admin.Invoice.Create', compact('user', 'doctors'));
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
                        ->whereNull('doctor_surgery.invoice_id');
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

            return view('admin.Invoice.Create', compact('doctor', 'user', 'surgeries', 'doctors', 'showSurgeryList', 'totalAmount'));
        }

        return view('admin.Invoice.Create', compact('user', 'doctors'));
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
        return redirect()->route('admin.InvoiceList');
    }
    public function destroy($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);

        // شروع تراکنش برای اطمینان از عدم وقوع خطا
        DB::beginTransaction();

        try {
            // 1. حذف پرداخت‌های مرتبط با این صورتحساب
            $invoice->payments()->delete();

            // 2. بروزرسانی جدول `doctor_surgery` و ست کردن `invoice_id` به `null`
            foreach ($invoice->surgeries as $surgery) {
                foreach ($surgery->doctors as $doctor) {
                    $doctor->pivot->update(['invoice_id' => null]);
                }
            }

            // 3. حذف فاکتور
            $invoice->delete();

            // تایید تراکنش
            DB::commit();

            Alert::success('موفقیت', 'فاکتور و پرداخت‌های مرتبط با موفقیت حذف شدند');
            return redirect()->route('admin.InvoiceList');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('خطا', 'خطایی در حذف فاکتور رخ داده است: ' . $e->getMessage());
            return redirect()->back();
        }
    }
    public function print($id)
    {
        $invoice = Invoice::with('doctor','payments')->findOrFail($id);

        $surgeryData = DB::table('doctor_surgery')
            ->where('doctor_surgery.invoice_id', $id)
            ->join('surgeries', 'doctor_surgery.surgery_id', '=', 'surgeries.id')
            ->join('operation_surgery', 'surgeries.id', '=', 'operation_surgery.surgery_id')
            ->join('operations', 'operation_surgery.operation_id', '=', 'operations.id')
            ->select(
                'surgeries.id as surgery_id',
                'surgeries.patient_name',
                'operations.name as operation_name',
                'surgeries.surgeried_at',
                'surgeries.released_at',
                'doctor_surgery.amount'
            )
            ->get();

        return view('admin.Invoice.print', [
            'invoice' => $invoice,
            'surgeryData' => $surgeryData
        ]);
    }
}
