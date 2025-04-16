<?php

namespace App\Http\Controllers\api\doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;

class invoiceController extends Controller
{
    public function index(Request $request)
    {
        $doctor = $request->user();

        $invoices = Invoice::where('doctor_id', $doctor->id)
            ->whereHas('payments')
            ->with('payments') 
            ->orderBy('created_at', 'desc')
            ->get();

        return InvoiceResource::collection($invoices);
    }

}
