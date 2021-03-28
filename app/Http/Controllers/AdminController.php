<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Post;
use App\User;
// use PragmaRX\Tracker\Vendor\Laravel\Facade as Tracker;
// use PragmaRX\Tracker\Tracker;


class AdminController extends Controller
{

    public function index (){
       $activePostCount = Post::where('status' , '1')->count();
        $notActivePostCount = Post::where('status' , '0')->count();

        $activeCategoryCount = Category::where('status' , '1')->count();
        $notActiveCategoryCount = Category::where('status' , '0')->count();

        $activeCommentCount = Comment::where('status' , '1')->count();
        $notActiveCommentCount = Comment::where('status' , '0')->count();
        
        $editorsCount = User::whereHas('roles', function ( $query) {
            $query->where('name', '!=', 'User');
        })->count();
        $usersCount = User::count() - $editorsCount;

        
        
        return view(adminview('index'), compact('activePostCount', 'notActivePostCount',
         'activeCategoryCount', 'notActiveCategoryCount',
          'activeCommentCount', 'notActiveCommentCount',
           'usersCount', 'editorsCount',
        ));
    }


}
