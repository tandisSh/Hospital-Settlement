<?php

namespace App\Http\Controllers\Panel;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    public function create($invoiceId)
    {
        $invoice = Invoice::with('doctor', 'payments')->findOrFail($invoiceId);

        if ($invoice->status == 1) {
            return redirect()->route('Panel.InvoiceList')->with('error', 'این صورتحساب تسویه شده است.');
        }

        $totalPaid = $invoice->payments->sum('amount');
        $remainingAmount = $invoice->amount - $totalPaid;

        return view('Panel.Payment.createPayment', [
            'invoice' => $invoice,
            'payments' => $invoice->payments,
            'totalPaid' => $totalPaid,
            'remainingAmount' => $remainingAmount
        ]);
    }
    public function storeCashPayment(Request $request)
    {
        $invoice = Invoice::with('payments')->findOrFail($request->invoice_id);

        if ($invoice->status == 1) {
            return redirect()->route('Panel.InvoiceList')->with('error', 'این صورتحساب تسویه شده است.');
        }

        $totalPaid = $invoice->payments->sum('amount');
        $remainingAmount = $invoice->amount - $totalPaid;

        $validated = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:1000',
                function ($attribute, $value, $fail) use ($remainingAmount) {
                    if ($value > $remainingAmount) {
                        $fail('مبلغ پرداختی نمی‌تواند بیشتر از '.number_format($remainingAmount).' تومان باشد.');
                    }
                }
            ],
            'receipt_number' => 'required|string|max:255',
            'receipt' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string|max:500'
        ]);

        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $request->amount,
            'pay_type' => 'cash',
            'receipt_number' => $request->receipt_number,
            'date' => now(),
            'due_date' => null,
            'receipt' => $this->uploadReceipt($request->file('receipt')),
            'description' => $request->description
        ]);

        $this->updateInvoiceStatus($invoice);

        Alert::success('موفق!', 'پرداخت نقدی با موفقیت ثبت شد.');
        return redirect()->route('Panel.InvoiceList')
               ->with('success', 'پرداخت نقدی با موفقیت ثبت شد.');
    }

    public function storeChequePayment(Request $request)
    {
        $invoice = Invoice::with('payments')->findOrFail($request->invoice_id);

        if ($invoice->status == 1) {
            return redirect()->route('Panel.InvoiceList')->with('error', 'این صورتحساب تسویه شده است.');
        }

        $totalPaid = $invoice->payments->sum('amount');
        $remainingAmount = $invoice->amount - $totalPaid;

        $validated = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:1000',
                function ($attribute, $value, $fail) use ($remainingAmount) {
                    if ($value > $remainingAmount) {
                        $fail('مبلغ پرداختی نمی‌تواند بیشتر از '.number_format($remainingAmount).' تومان باشد.');
                    }
                }
            ],
            'cheque_number' => 'required|string|max:255',
            'due_date' => [
                'required',
                function ($attribute, $value, $fail) {
                    try {
                        \Morilog\Jalali\Jalalian::fromFormat('Y/m/d', $value);
                    } catch (\Exception $e) {
                        $fail('فرمت تاریخ معتبر نیست. لطفا تاریخ را به صورت شمسی وارد کنید (مثال: 1402/05/15)');
                    }
                }
            ],
            'receipt' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'cheque_description' => 'nullable|string|max:500'
        ]);

        // تبدیل تاریخ شمسی به میلادی
        $jDate = \Morilog\Jalali\Jalalian::fromFormat('Y/m/d', $request->due_date);
        $gregorianDate = $jDate->toCarbon()->toDateString();

        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $request->amount,
            'pay_type' => 'cheque',
            'cheque_number' => $request->cheque_number,
            'date' => now(),
            'due_date' => $gregorianDate, // ذخیره به صورت میلادی
            'receipt' => $this->uploadReceipt($request->file('receipt')),
            'description' => $request->cheque_description
        ]);

        $this->updateInvoiceStatus($invoice);

        Alert::success('موفق!', 'پرداخت چکی با موفقیت ثبت شد.');
        return redirect()->route('Panel.InvoiceList')
               ->with('success', 'پرداخت چکی با موفقیت ثبت شد.');
    }
    private function updateInvoiceStatus(Invoice $invoice)
    {
        // محاسبه مجموع پرداخت‌های مربوط به این فاکتور
        $totalPaid = Payment::where('invoice_id', $invoice->id)->sum('amount');

        // بررسی وضعیت فعلی فاکتور
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
        $fileName = 'receipt_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads/receipts'), $fileName);
        return $fileName;
    }
}
