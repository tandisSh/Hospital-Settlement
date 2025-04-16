<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class InsuranceController extends Controller
{
    public function List()
    {
        $insurances = Insurance::orderBy('created_at', 'desc')->get();;
        return view('admin.Insurance.List', compact('insurances'));
    }
    public function create()
    {
        return view('admin.Insurance.Create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:insurances,name',
            'type' => 'required|in:basic,supplementary',
            'discount' => 'required|integer|min:0|max:100',
            'status' => 'required|boolean',
        ]);

        Insurance::create($request->all());

        Alert::success('موفق!', 'بیمه با موفقیت ثبت شد.');
        return redirect()->route('insurances')->with('success', 'بیمه جدید با موفقیت ثبت شد.');
    }
    public function edit($id)
    {
        $insurance = Insurance::findOrFail($id);
        return view('admin.Insurance.Edit', compact('insurance'));
    }
    public function update(Request $request, $id)
    {
        $insurance = Insurance::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:insurances,name,' . $id,
            'type' => 'required|in:basic,supplementary',
            'discount' => 'required|integer|min:0|max:100',
            'status' => 'required|boolean',
        ]);

        $insurance->update($request->all());

        Alert::success('موفق!', 'بیمه با موفقیت ویرایش شد.');
        return redirect()->route('insurances')->with('success', 'بیمه با موفقیت ویرایش شد.');
    }
    public function delete($id)
    {

        $insurance = Insurance::findOrFail($id);
        $insurance->delete();

        return redirect()->route('insurances')->with('success', 'بیمه با موفقیت حذف شد.');
    }
}
