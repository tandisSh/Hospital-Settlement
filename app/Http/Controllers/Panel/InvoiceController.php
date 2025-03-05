<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Surgery;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('doctor')->latest()->get();
        return view('Panel.Invoice.List', compact('invoices'));
    }

    public function create()
    {
        $doctors = Doctor::all();
        return view('Panel.Invoice.Create', compact('doctors'));
    }

    public function searchSurgeries(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date'
        ]);

        $surgeries = Surgery::whereHas('doctors', function($query) use ($validated) {
            $query->where('doctor_id', $validated['doctor_id']);
        })->whereBetween('surgery_date', [$validated['from_date'], $validated['to_date']])
          ->with(['doctors' => function($query) use ($validated) {
              $query->where('doctor_id', $validated['doctor_id']);
          }])
          ->get();

        return response()->json($surgeries);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'surgery_ids' => 'required|array',
            'surgery_ids.*' => 'exists:surgeries,id',
            'description' => 'nullable|string'
        ]);

        $surgeries = Surgery::whereIn('id', $validated['surgery_ids'])
            ->with(['doctors' => function($query) use ($validated) {
                $query->where('doctor_id', $validated['doctor_id']);
            }])
            ->get();

        $totalAmount = $surgeries->sum(function($surgery) {
            return $surgery->doctors->first()->pivot->price ?? 0;
        });

        $invoice = Invoice::create([
            'doctor_id' => $validated['doctor_id'],
            'amount' => $totalAmount,
            'description' => $validated['description'],
            'status' => false
        ]);

        return redirect()->route('panel.invoices.index')
            ->with('success', 'صورتحساب با موفقیت ثبت شد.');
    }

    public function edit(Invoice $invoice)
    {
        $doctors = Doctor::all();
        return view('Panel.Invoice.Edit', compact('invoice', 'doctors'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'boolean'
        ]);

        $invoice->update($validated);

        return redirect()->route('panel.invoices.index')
            ->with('success', 'صورتحساب با موفقیت بروزرسانی شد.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('panel.invoices.index')
            ->with('success', 'صورتحساب با موفقیت حذف شد.');
    }
} 