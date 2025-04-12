<?php

namespace App\Http\Controllers\admin;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    public function create($invoiceId)
    {
        $invoice = Invoice::with('doctor', 'payments')->findOrFail($invoiceId);

        if ($invoice->status == 1) {
            Alert::error('خطا', 'این صورتحساب قبلاً تسویه شده است.');
            return redirect()->route('admin.InvoiceList');
        }

        $totalPaid = $invoice->payments->sum('amount');
        $remainingAmount = $invoice->amount - $totalPaid;

        return view('admin.Payment.createPayment', [
            'invoice' => $invoice,
            'payments' => $invoice->payments,
            'totalPaid' => $totalPaid,
            'remainingAmount' => $remainingAmount
        ]);
    }
    public function storePayment(Request $request)
    {
        $invoice = Invoice::with('payments')->findOrFail($request->invoice_id);

        // بررسی وضعیت صورتحساب
        if ($invoice->status == 1) {
            Alert::error('خطا', 'این صورتحساب قبلاً تسویه شده است.');
            return redirect()->route('admin.InvoiceList');
        }

        // محاسبه مبلغ باقیمانده
        $totalPaid = $invoice->payments->sum('amount');
        $remainingAmount = $invoice->amount - $totalPaid;

        // اعتبارسنجی داده‌های ورودی
        $validated = $request->validate([
            'pay_type' => 'required|in:cash,cheque',
            'amount' => [
                'required',
                'numeric',
                'min:1000',
                function ($attribute, $value, $fail) use ($remainingAmount) {
                    if ($value > $remainingAmount) {
                        $fail('مبلغ پرداختی نمی‌تواند بیشتر از ' . number_format($remainingAmount) . ' تومان باشد.');
                    }
                }
            ],
            'receipt_number' => 'required_if:pay_type,cash|string|max:255|nullable',
            'cheque_number' => 'required_if:pay_type,cheque|nullable|string|max:255',

            'due_date' => [
                'required_if:pay_type,cheque',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->pay_type === 'cheque') {
                        try {
                            \Morilog\Jalali\Jalalian::fromFormat('Y/m/d', $value);
                        } catch (\Exception $e) {
                            $fail('فرمت تاریخ معتبر نیست. لطفا تاریخ را به صورت شمسی وارد کنید (مثال: 1402/05/15)');
                        }
                    }
                }
            ],
            'receipt' => 'required_if:pay_type,cheque|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string|max:500'
        ]);

        // شروع تراکنش دیتابیس
        DB::beginTransaction();

        try {
            // آماده سازی داده‌های پرداخت
            $paymentData = [
                'invoice_id' => $invoice->id,
                'amount' => $request->amount,
                'pay_type' => $request->pay_type,
                'description' => $request->description,
                'date' => now(),
                'receipt' => $request->hasFile('receipt')
                    ? $this->uploadReceipt($request->file('receipt'))
                    : null
            ];

            // پرداخت نقدی
            if ($request->pay_type === 'cash') {
                $paymentData['receipt_number'] = $request->receipt_number;
                $paymentData['cheque_number'] = null;
                $paymentData['due_date'] = null;
            }
            // پرداخت چکی
            else {
                $paymentData['cheque_number'] = $request->cheque_number;
                $paymentData['receipt_number'] = null;

                // تبدیل تاریخ شمسی به میلادی
                $jDate = \Morilog\Jalali\Jalalian::fromFormat('Y/m/d', $request->due_date);
                $paymentData['due_date'] = $jDate->toCarbon()->toDateString();
            }

            // ایجاد رکورد پرداخت
            $payment = Payment::create($paymentData);

            // به‌روزرسانی وضعیت صورتحساب
            $this->updateInvoiceStatus($invoice);

            // کامیت تراکنش
            DB::commit();

            $message = $request->pay_type === 'cash'
                ? 'پرداخت نقدی با موفقیت ثبت شد.'
                : 'پرداخت چکی با موفقیت ثبت شد.';

            Alert::success('موفقیت', $message);
            return redirect()->route('admin.InvoiceList');
        } catch (\Exception $e) {
            // برگشت تراکنش در صورت خطا
            DB::rollBack();

            Alert::error('خطا', 'خطایی در ثبت پرداخت رخ داد: ' . $e->getMessage());
            return back()->withInput();
        }
    }
    private function updateInvoiceStatus(Invoice $invoice)
    {
        $totalPaid = Payment::where('invoice_id', $invoice->id)->sum('amount');

        if ($totalPaid >= $invoice->amount && $invoice->status != 1) {
            $invoice->update(['status' => 1]);
            return true;
        } elseif ($totalPaid < $invoice->amount && $invoice->status == 1) {
            $invoice->update(['status' => 0]);
            return true;
        }

        return false;
    }
    private function uploadReceipt($file)
    {
        $fileName = 'receipt_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/receipts'), $fileName);
        return $fileName;
    }
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $invoiceId = $payment->invoice_id;

        $payment->delete();

        // آیدی رو به مدل تبدیل می‌کنیم
        $invoice = Invoice::findOrFail($invoiceId);
        $this->updateInvoiceStatus($invoice);

        return redirect()->route('admin.Payment.show', ['id' => $invoiceId])
            ->with('success', 'پرداخت با موفقیت حذف شد.');
    }
    public function show($id)
    {
        $invoice = Invoice::with('payments')->findOrFail($id);
        return view('admin.Payment.print', compact("invoice"));
    }
}
