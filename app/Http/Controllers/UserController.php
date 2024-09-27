<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if(!auth()->user()->can('عرض المستخدمين'))
        // {
        //     abort(403);
        // }
        $records = User::paginate(20);
        return view("users.index", compact("records"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // if(!auth()->user()->can('انشاء المستخدمين'))
        // {
        //     abort(403);
        // }
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // if(!auth()->user()->can('انشاء المستخدمين'))
        // {
        //     abort(403);
        // }
        $request->validate([
            "name" => "required",
            "email" => "required|unique:users",
            "password" => "required|confirmed",
            'roles_list' => 'required'
        ]);
        $user = User::create($request->except('roles_list', 'permission_list'));
        $user->roles()->attach($request->input('roles_list'));
        session()->flash('success', 'تم اضافة مستخدم بنجاح');
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // if(!auth()->user()->can('تعديل المستخدمين'))
        // {
        //     abort(403);
        // }
        $user = User::find($id);
        return view("users.edit", compact("user"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // if(!auth()->user()->can('تعديل المستخدمين'))
        // {
        //     abort(403);
        // }
        $request->validate([
            "name" => "required|unique:users,name,$id",
            "email" => "required",
            "password" => "confirmed",
            'roles_list' => 'required'
        ]);
        $user = User::findOrFail($id);
        $user->roles()->sync((array) $request->input('roles_list'));
        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $update = $user->update($request->except('password'));
        session()->flash('success', 'تم تعديل المستخدم بنجاح');
        return redirect()->route('user.edit',$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // if(!auth()->user()->can('حذف المستخدمين'))
        // {
        //     abort(403);
        // }
        $user = User::find($id);
        if (!$user) {
            session()->flash('error', 'المستخدم غير موجود');
        }
        $user->delete();
        session()->flash('success', 'تم حذف المستخدم بنجاح');
        return redirect()->route('user.index');
    }
}
