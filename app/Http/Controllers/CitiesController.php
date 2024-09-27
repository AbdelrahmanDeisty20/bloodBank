<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Governorate;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = City::with('governorate')->paginate(20);
        return view('cities.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $governorates = Governorate::all();
        return view('cities.create',compact('governorates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'governorate_id'=> 'required',
        ]);
        $record= City::create($request->all());
        session()->flash('success','تم اضافة مدينة جديدة بنجاح');
        return redirect()->route('cities.index');
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
        $model = City::findOrFail($id);
        return view('cities.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=> 'required',
        ]);
        $record = City::findOrFail($id);
        $record->update($request->all());
        return redirect()->route('cities.index')->with('success','تم تعديل المدينة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = City::findOrFail($id);
        $record->delete();
        return redirect()->route('cities.index')->with('success','تم الحذف بنجاح');
    }
}
