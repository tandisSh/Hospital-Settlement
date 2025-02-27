<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Insurance;
use App\Models\Operation;
use App\Models\Surgery;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SurgeryController extends Controller
{
    public function List()
    {
        $surgeries = Surgery::with(['basicInsurance', 'suppInsurance', 'doctors', 'operations'])->orderBy('created_at', 'desc')->get();
        return view('Panel.surgery.List', compact('surgeries'));
    }
    public function create()
    {
        $insurances = Insurance::all();
        $doctors = Doctor::all();
        $operations = Operation::all();
        return view('Panel.surgery.create', compact('insurances', 'doctors', 'operations'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:100',
            'patient_national_code' => 'required|string|max:20',
            'basic_insurance_id' => 'nullable|exists:insurances,id',
            'supp_insurance_id' => 'nullable|exists:insurances,id',
            'document_number' => 'required|unique:surgeries,document_number',
            'surgeried_at' => 'required|date',
            'released_at' => 'required|date|after_or_equal:surgeried_at',
        ]);

        $surgery = Surgery::create($request->all());
        $surgery->doctors()->attach($request->doctors);
        $surgery->operations()->attach($request->operations);

        Alert::success('موفق!', 'عمل جراحی با موفقیت ثبت شد.');
        return redirect()->route('surgeries')->with('success', 'عمل جراحی با موفقیت ثبت شد.');
    }
    public function edit($id)
    {
        $surgery = Surgery::findOrFail($id);
        $insurances = Insurance::all();
        $doctors = Doctor::all();
        $operations = Operation::all();
        return view('Panel.surgery.edit', compact('surgery', 'insurances', 'doctors', 'operations'));
    }
    public function update(Request $request, $id)
    {
        $surgery = Surgery::findOrFail($id);

        $dataform = $request->all();

        $surgery->update($dataform);
        $surgery->doctors()->sync($request->doctors);
        $surgery->operations()->sync($request->operations);

        return redirect()->route('surgeries')->with('success', 'اطلاعات عمل جراحی با موفقیت بروزرسانی شد.');
    }
    public function delete($id)
    {
        $surgery = Surgery::findOrFail($id);
        $surgery->delete();
        return redirect()->route('surgeries')->with('success', 'عمل جراحی حذف شد.');
    }
}
