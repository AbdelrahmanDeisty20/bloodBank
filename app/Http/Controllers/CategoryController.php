<?php

namespace App\Http\Controllers;

use App\Models\CatgoryType;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $records= CatgoryType::paginate(20);
        return view('categories.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'اسم الفئة مطلوب',
        ]);
        CatgoryType::create($request->all());
        session()->flash('success', 'تم اضافة فئة جديدة بنجاح');
        return redirect()->route('categories.index');
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
        
        $model= CatgoryType::findOrFail($id);
        return view('categories.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'اسم الفئة مطلوب',
        ]);
        $records= CatgoryType::findOrFail($id);
        $records->update($request->all());
        session()->flash('success', 'تم تعديل الفئة بنجاح');
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $records= CatgoryType::findOrFail($id);
        $records->delete();
        session()->flash('success','تم حذف الفئة بنجاح');
        return redirect()->route('categories.index');
    }
}
