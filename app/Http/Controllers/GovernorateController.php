<?php

namespace App\Http\Controllers;

use App\Models\Governorate;
use Illuminate\Http\Request;

class GovernorateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records= Governorate::paginate(20);
        return view("governorates.index",compact("records"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('governorates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
        // $governorate = new Governorate();
        // $governorate->name = $validatedData['name'];
        // $governorate->save();
        Governorate::create($request->all());
        return redirect()->route('governorate.index')->with('success', 'تم اضافة محافظة بنجاح');
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
        $model = Governorate::findOrFail($id);
        return view('governorates.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = Governorate::findOrFail($id);
        $record->update($request->all());
        return redirect()->route('governorate.index')->with('success', 'تم تعديل المحافظ بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $record = Governorate::findOrFail($id);
        // $record->delete();
        Governorate::destroy($id);
        return redirect()->route('governorate.index')->with('success','تم الحذف بنجاح');
    }
}
