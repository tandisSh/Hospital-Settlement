<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Surgery;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
class InvoiceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $invoices = Invoice::all();
        return view('Panel.Invoice.List', compact('invoices','user'));
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
                ->whereHas('doctors', function($query) use ($request) {
                    $query->where('doctors.id', $request->doctor_id);
                })
                ->when($startDate, function($query) use ($startDate) {
                    $query->where('surgeried_at', '>=', $startDate);
                })
                ->when($endDate, function($query) use ($endDate) {
                    $query->where('surgeried_at', '<=', $endDate);
                })
                ->get()
                ->map(function($surgery) use ($doctor) {
                    $doctorSurgery = $surgery->doctors->where('id', $doctor->id)->first();
                    $roleName = $doctorSurgery ? $doctor->roles->where('id', $doctorSurgery->pivot->doctor_role_id)->first()->title : 'تعیین نشده';
                    $amount = $doctorSurgery ? $doctorSurgery->pivot->amount : 0;

                    return [
                        'id' => $surgery->id,
                        'patient_name' => $surgery->patient_name,
                        'operations' => $surgery->operations,
                        'role_name' => $roleName,
                        'amount' => $amount,
                        'surgeried_at' => Jalalian::fromDateTime($surgery->surgeried_at)->format('Y/m/d') // تبدیل به شمسی
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
                'total_amount' => 'required|numeric|min:0'
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


// Start transaction

                $invoice = Invoice::create([
                    'doctor_id' => $request->doctor_id,
                    'amount' => $request->total_amount,
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Update each surgery with the invoice ID
                foreach ($surgeries as $surgery) {
                    $surgery->doctors()->updateExistingPivot($request->doctor_id, [
                        'invoice_id' => $invoice->id
                    ]);
                }


                Alert::success('موفقیت', 'صورتحساب با موفقیت ایجاد شد');
                return redirect()->route('Panel.Invoice.List');

    }
public function invoiceList()
{
    $user = Auth::user();
    $invoices = Invoice::all();
    return view('Panel.Invoice.List', compact('invoices', 'user'));
}
}
