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

    // return response()->json([
    //     'message' => 'لیست جراحی‌ها',
    //     'surgeries' => $surgeries,
    // ]);
    return response()->success(
        [
                    'massage' =>"لیست جراحی‌ها ",
                    'surgeries' => $surgeries,
        ],
        'لیست جراحی‌ها با موفقیت  بازیابی شد'
        );
}
public function show(Request $request, $id)
{
    $doctor = $request->user();

    $surgery = Surgery::with(['basicInsurance', 'suppInsurance', 'doctors', 'operations'])
                      ->whereHas('doctors', function ($query) use ($doctor) {
                          $query->where('doctors.id', $doctor->id);
                      })
                      ->where('id', $id)
                      ->first();

    if (! $surgery) {
        // return response()->json(['message' => 'جراحی پیدا نشد یا مربوط به شما نیست'], 404);

        return response()->error('جراحی پیدا نشد یا مربوط به شما نیست',404);
    }

    // return response()->json([
    //     'message' => 'اطلاعات جراحی',
    //     'surgery' => $surgery,
    // ]);
    return response()->success(
        [
                    'massage' =>"اطلاعات جراحی‌ها ",
                    'surgery' => $surgery,
        ]

        ,' جراحی‌ با موفقیت  بازیابی شد'
        );
}

}
