<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function index(Request $request)
    {
        $doctor = $request->user();

        $payments = Payment::with('invoice')
            ->whereHas('invoice', function ($query) use ($doctor) {
                $query->where('doctor_id', $doctor->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        //گروه بندی براساس نوع پرداخت
        $grouped = $payments->groupBy('pay_type')->map(function ($group) {
            return [
                'total_amount' => $group->sum('amount'),
                'count'        => $group->count(),
                'payments'     => PaymentResource::collection($group),
            ];
        });

        return response()->json([
            'doctor_id' => $doctor->id,
            'grouped_payments' => $grouped,
        ]);
    }
}
