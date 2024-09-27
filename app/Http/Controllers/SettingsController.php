<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function index()
    {
        return view('settings');
    }
    public function store(Request $request)
    {
        $request->validate([
            'youtube_link'=>'required',
            'facebook_link'=>'required',
            'twitter_link'=> 'required',
            'instagram_link'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'about_app'=>'required',
            'about_address'=>'required'
        ]);
        Setting::create($request->all());
        return redirect()->back()->with('success','تم الضافة بنجاح');
    }
}
