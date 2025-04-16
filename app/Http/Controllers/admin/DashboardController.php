<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Operation;
use App\Models\Payment;
use App\Models\Surgery;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $doctors = Doctor::all();
        $doctorCount = $doctors->count();
        $invoiceCount = Invoice::count();
        $surgeryCount = Surgery::count();

        $upcomingChecks = Payment::with('invoice.doctor')
            ->where('pay_type', 'cheque')
            ->whereDate('due_date', '<=', now()->addDays(7))
            ->orderBy('due_date')
            ->get();

        return view('Admin.index', compact(
            'doctors',
            'doctorCount',
            'invoiceCount',
            'surgeryCount',
            'upcomingChecks'
        ));
    }
}
