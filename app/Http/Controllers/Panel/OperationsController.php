<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class OperationsController extends Controller
{
    public function List()
    {
        $operations = Operation::orderBy('created_at', 'desc')->get();
        return view('Panel.Operation.List', compact('operations'));
    }
    public function create()
    {
        return view('Panel.Operation.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:operations',
            'price' => 'required|integer|min:0',
            'status' => 'required|boolean',
        ]);

        Operation::create($request->all());

        Alert::success('موفق!', 'عمل با موفقیت ثبت شد.');
        return redirect()->route('operations')->with('success', 'عمل جدید ایجاد شد.');
    }

    public function edit($id)
    {
        $operation=Operation::find($id);
        return view('Panel.Operation.edit', compact('operation'));
    }

    public function update(Request $request, $id)
    {
        $operation=Operation::find($id);
        $dataform = $request->all();

        $operation->update($dataform);
        Alert::success('موفق!', 'عمل با بروزرسانی ثبت شد.');
        return redirect()->route('operations')->with('success', 'عمل با موفقیت بروزرسانی شد.');
    }
    public function delete($id)
    {
        $operation = Operation::find($id);
        $operation->delete();
        return redirect()->route('operations')->with('success', 'عمل با موفقیت حذف شد.');
    }
}
