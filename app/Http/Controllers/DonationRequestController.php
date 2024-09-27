<?php

namespace App\Http\Controllers;

use App\Models\DonationRequest;
use Illuminate\Http\Request;

class DonationRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records= DonationRequest::with('bloodType','clients')->paginate(20);
        return view('donationRequests.index', compact('records'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model= DonationRequest::findOrFail($id);
        return view('donationRequests.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model= DonationRequest::findOrFail($id);
        $model->delete();
        return redirect()->route('donationRequests.index')->with('success','تم الحذف بنجاح');
    }
}
