<?php

namespace App\Http\Controllers;

use App\Models\BloodType;
use Illuminate\Http\Request;

class bloodTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = BloodType::all();
        return view("bloodTypes.index", compact("records"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bloodTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'=> 'required',
        ]);
        BloodType::create($request->all());
        return redirect()->route('bloodTypes.index')->with('success',' تم اضافة فئة دم جديدة بنجاح');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model= BloodType::findOrFail($id);
        return view('bloodTypes.edit' , compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'name'=> 'required',
        ]);
        BloodType::findOrFail($id)->update($request->all());
        return redirect()->route('bloodTypes.index')->with('success',' تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = BloodType::findOrFail($id);
        $model->delete();
        return redirect()->route('bloodTypes.index')->with('success','تم الحذف بنجاح');
    }
}
