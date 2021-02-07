<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::when($request->search, function ($query) use ($request) {
            $search = $request->search;

            return $query->where('title', 'like', "%$search%")
                            ->orWhere('body', 'like', "%$search%");
        })->with('user')
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
