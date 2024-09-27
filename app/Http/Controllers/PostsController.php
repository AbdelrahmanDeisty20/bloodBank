<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\CatgoryType;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Post::with('category')->paginate(20);
        return view("posts.index", compact("records"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CatgoryType::all();
        return view("posts.create", compact("categories"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "title" => "required",
            "content" => "required",
            "image" => "required|image|mimes:jpg,png,jpeg,gif,svg|max:2048",
            "category_id" => "required",
        ]);
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->image = 'images/' . $imageName;
        $post->category_id = $request->input('category_id');
        $post->save();
        return redirect()->route("posts.index")->with("success", "تم اضافة المقالة بنجاح");
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
        $model = Post::findOrFail($id);
        return view('posts.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $records = Post::findOrFail($id);
        $records->update($request->all());
        return redirect()->route('posts.index')->with('success', "تم تعديل المقالة بنجاح");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $records = Post::findOrFail($id);
        $records->delete();
        return redirect()->route('posts.index')->with('success', "تم حذف المقالة بنجاح");
    }
}
