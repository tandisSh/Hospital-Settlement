<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('invoice')->latest()->paginate(15);
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $invoices = Invoice::all();
        return view('payments.create', compact('invoices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0',
            'pay_type' => 'required|in:cash,cheque',
            'date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:date',
            'receipt' => 'nullable|string|max:191',
            'description' => 'nullable|string',
            'status' => 'boolean',
        ]);

        Payment::create($validated);

        return redirect()->route('payments.index')->with('success', 'پرداخت با موفقیت ثبت شد.');
    }

    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return back()->with('success', 'پرداخت حذف شد.');
    }
}

