<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with('user')
                    ->simplePaginate(5);
        if ($request->ajax()) 
        {
            $posts = Post::orderBy('updated_at', 'DESC')->with('user')
                        ->simplePaginate(5);
            return view('frontend.data', compact('posts'));
        }
        return view('frontend.index', compact('posts'));
    }
}
