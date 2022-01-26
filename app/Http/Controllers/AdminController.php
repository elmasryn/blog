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

    public function index()
    {
        $statistics['activePostCount'] = Post::where('status', '1')->count();
        $statistics['notActivePostCount'] = Post::where('status', '0')->count();

        $statistics['activeCategoryCount'] = Category::where('status', '1')->count();
        $statistics['notActiveCategoryCount'] = Category::where('status', '0')->count();

        $statistics['activeCommentCount'] = Comment::where('status', '1')->count();
        $statistics['notActiveCommentCount'] = Comment::where('status', '0')->count();

        $statistics['editorsCount'] = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'User');
        })->count();
        $statistics['usersCount'] = User::count() - $statistics['editorsCount'];



        return view(adminview('index'), $statistics);
    }
}
