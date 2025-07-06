<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CommonController extends Controller
{
    public function user(Request $request): View
    {
        $users = DB::table('users')->get();
        return view('user', compact('users'));
    }
    public function blog(Request $request): View
    {
        $users = DB::table('blogs')->get();
        return view('blogs/blogs', compact('users'));
    }
    public function blog_update(Request $request): View
    {
        $users = DB::table('blogs')->get();
        return view('blogs/blog_update', compact('users'));
    }
    public function store(Request $request){
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
        }
        DB::table('blogs')->insert([
    'title' => $request->input('title'),
    'hash' => $request->input('subtitle'),
    'disc' => $request->input('content'),
    'tags' => $request->input('tags'),
    'upload_by' => Auth::user()->name,
    'img' => $imagePath
]);
    
        return response()->json(['success' => true, 'message' => 'Blog post created.']);
    }
    
    public function destroy($id)
{
    $deleted = DB::table('blogs')->where('id', $id)->delete();

    if ($deleted) {
        return response()->json(['success' => true, 'message' => 'Blog deleted successfully']);
    } else {
        return response()->json(['success' => false, 'message' => 'Blog not found or already deleted']);
    }
}
}
