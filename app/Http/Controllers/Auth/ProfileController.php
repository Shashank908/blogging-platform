<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user(); 
        if (!empty($user)) 
        {
            $post_controller = new PostController;
            $data = $post_controller->getPosts($user->id);
            $post_count = count($data);
            return view('admin.profile.index', compact('user', 'post_count'));
        }
        return redirect('/home');
    }
}
