<?php

namespace App\Http\Controllers;

use App\Post;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts       = Post::where('status','1')->select('title','body','slug','thumbnail')->orderBy('id','desc')->offset(1)->limit(6)->get();
        $post_middle = Post::where('status','1')->select('title','body','slug','thumbnail')->orderBy('id','desc')->offset(7)->first();
        $posts_slide = Post::where('status','1')->select('title','body','slug','thumbnail')->orderBy('id','desc')->offset(8)->limit(3)->get();
        return view('index', compact('posts','post_middle','posts_slide'));
    }
}
