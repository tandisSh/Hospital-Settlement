<?php

namespace App\Http\Controllers\api\doctor;

use App\Http\Controllers\Controller;
use App\Models\DoctorSurgery;
use App\Models\Surgery;
use Illuminate\Http\Request;

class SurgeryController extends Controller
{
    public function list(Request $request)
{
    $doctor = $request->user();

    $surgeries = DoctorSurgery::with(['surgery','doctorRole'])
                         ->where('doctor_id', $doctor->id)
                         ->orderBy('created_at', 'desc')
                         ->get();

    return response()->json([
        'message' => 'لیست جراحی‌ها',
        'surgeries' => $surgeries,
    ]);
}

}
