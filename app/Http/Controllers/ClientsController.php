<?php

namespace App\Http\Controllers;

use App\Models\BloodType;
use App\Models\City;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records= Client::paginate(20);
        return view('clients.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $model= Client::findOrFail($id);
        $model->delete();
        return redirect()->route('clients.index')->with('success', 'تم الحذف بنجاح');
    }
}
