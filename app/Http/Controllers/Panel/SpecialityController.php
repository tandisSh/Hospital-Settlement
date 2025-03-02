<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Speciality;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{
    public function List()
    {
        $specialities = Speciality::orderBy('created_at', 'desc')->get();
        return view('Panel.Speciality.SpecialitiesList', compact('specialities'));
    }
    public function Create()
    {
        return view('Panel.Speciality.CreateSpeciality');
    }
    public function Store(Request $request)
    {
        $request->validate([
            "title" => "required|unique:specialities,title",
            "status" => "required|boolean",
        ]);

        Speciality::create($request->all());
        return redirect()->route("Show.Speciality")->with('success', 'تخصص با موفقیت ثبت شد.');
    }
    public function Edit($id)
    {
        $Speciality = Speciality::findOrFail($id);
        return view('Panel.Speciality.EditSpeciality', compact('Speciality'));
    }
    public function Update(Request $request, $id)
    {
        $Speciality = Speciality::findOrFail($id);
        
        $request->validate([
            "title" => "required|unique:specialities,title," . $id,
            "status" => "required|boolean",
        ]);

        $Speciality->update($request->all());
        return redirect()->route('Show.Speciality')->with('success', 'تخصص با موفقیت ویرایش شد.');
    }
    public function Delete($id)
    {
        $Speciality = Speciality::findOrFail($id);
        $Speciality->delete();
        return redirect()->route('Show.Speciality')->with('success', 'تخصص با موفقیت حذف شد.');
    }
}
