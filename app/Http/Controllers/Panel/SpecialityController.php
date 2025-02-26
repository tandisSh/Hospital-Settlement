<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Speciality;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SpecialityController extends Controller
{
    public function List()
    {
        $specialities = Speciality::all();
        return view('Panel.Speciality.SpecialitiesList', compact('specialities'));
    }
    public function Create()
    {
        return view('Panel.Speciality.CreateSpeciality');
    }
    public function Store(Request $request)
    {
        $request->validate([
            "title" => "required",
            "status" => "required",
        ]);

        $title = Speciality::where("title", $request->title)->first();

        if (!$title) {
            $Speciality = Speciality::create([
                'title' => $request->title,
                'status' => $request->status,
            ]);

            Alert::success('موفق!', 'تخصص با موفقیت ثبت شد.');
            return redirect()->route("Show.Speciality");
        } else {
            Alert::error('خطا!', " تخصص از قبل وجود دارد.");
            return redirect()->route("Speciality.Create.Form");
        }
    }
    public function Edit($id)
    {
        $Speciality = Speciality::find($id);
        return view('Panel.Speciality.EditSpeciality', compact('Speciality'));
    }
    public function Update(Request $request, $id)
    {
        $Speciality = Speciality::find($id);
        $dataform = $request->all();
        $Speciality->update($dataform);

        Alert::success('موفق!', 'تخصص با موفقیت ویرایش شد.');
        return redirect()->route('Show.Speciality');
    }
    public function Delete(Request $request, $id)
    {
        $Speciality = Speciality::find($id);

        $Speciality->delete();
        return redirect()->route('Show.Speciality')->with('success', 'کاربر با موفقیت حذف شد.');
    }
}
