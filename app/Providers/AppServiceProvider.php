<?php

namespace App\Providers;

use App\Category;
use App\Comment;
use App\Message;
use App\Message_title;
use App\Page;
use App\Post;
use App\Tag;
use App\User;
use App\Website_content;
use Hamcrest\Core\AnyOf;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('role', function (...$who) {
            return auth()->check() && count(auth()->user()->roles->pluck('name')->intersect($who)) > 0;
        });

        Blade::if('management', function () {
            if(auth()->check()){
                return count(auth()->user()->roles->pluck('name')->intersect(['Admin','Editor'])) > 0;
            }
        });


        //backEnd
        view()->composer(adminview('sidebar'), function ($view) {
            $view->with('lastCategories', Category::orderBy('id','desc')->pluck('title_'.app()->getLocale(),'slug')->take(3));
            $view->with('lastPages'     , Page::orderBy('id','desc')->pluck('title_'.app()->getLocale(),'slug')->take(3));
            $view->with('lastUsers'     , User::orderBy('id','desc')->pluck('name','id')->take(3));
            $view->with('lastPosts'     , Post::orderBy('id','desc')->pluck('title','slug')->take(3));
            $view->with('lastTags'      , Tag::orderBy('id','desc') ->pluck('name','slug')->take(3));
            $view->with('lastComments'  , Comment::with(['post' => function ($query) {
                $query->withoutGlobalScope('status')->select('id', 'slug');
            }])->orderBy('id','desc')->take(3)->get());
            $view->with('Pagescount'    , Page::count());
        });

        view()->composer(adminview('navbar'), function ($view) {
            $view->with('messages', Message::where('read', 'new')->orderBy('id', 'desc')->get());
        });

        view()->composer(adminview('posts'), function ($view) {
            if (request()->has('postTag') && request()->filled('postTag'))
                $view->with('tagName', Tag::findOrFail(request()->postTag)->name);
            if (request()->has('postCategory') && request()->filled('postCategory'))
                $view->with('categoryTitle', Category::findOrFail(request()->postCategory)->{'title_'.app()->getLocale()});
            if (request()->has('postUser') && request()->filled('postUser'))
                $view->with('userName', User::findOrFail(request()->postUser)->name);
        });

        view()->composer(adminview('comments'), function ($view) {
            if (request()->has('commentPost') && request()->filled('commentPost'))
                $view->with('postTitle', Post::findOrFail(request()->commentPost)->title);
            if (request()->has('commentUser') && request()->filled('commentUser'))
                $view->with('userName', User::findOrFail(request()->commentUser)->name);
        });

        view()->composer([adminview('messages.messages')], function ($view) {
            $view->with('messagesCount', Message::count());
            $view->with('unreadMessagesCount', Message::where('read', 'new')->count());
            $view->with('readMessagesCount', Message::where('read', 'old')->count());
            $view->with('trashedMessagesCount', Message::onlyTrashed()->count());
            $view->with('message_titles', Message_title::all());
        });

        //frontEnd
        view()->composer('layouts/app', function ($view) {
            $view->with('footer_head_1'  , Website_content::where('area_id',4) ->pluck('value')->first());
            $view->with('footer_head_2'  , Website_content::where('area_id',5) ->pluck('value')->first());
            $view->with('footer_head_3'  , Website_content::where('area_id',6) ->pluck('value')->first());
            $view->with('footer_head'    , Website_content::where('area_id',7) ->pluck('value')->first());
            $view->with('footer_content' , Website_content::where('area_id',8) ->pluck('value')->first());
            $view->with('facebook'       , Website_content::where('area_id',9) ->pluck('link') ->first());
            $view->with('twitter'        , Website_content::where('area_id',10)->pluck('link') ->first());
            $view->with('google'         , Website_content::where('area_id',11)->pluck('link') ->first());
            $view->with('linkedin'       , Website_content::where('area_id',12)->pluck('link') ->first());
            $view->with('gmail'          , Website_content::where('area_id',13)->pluck('link') ->first());
            $view->with('other_social'   , Website_content::where('area_id',14)->pluck('value','link'));
            $view->with('footer_col_1'   , Website_content::where('area_id',1) ->pluck('value','link'));
            $view->with('footer_col_2'   , Website_content::where('area_id',2) ->pluck('value','link'));
            $view->with('footer_col_3'   , Website_content::where('area_id',3) ->pluck('value','link'));
            $view->with('post_header'    , Post::where('status','1')->select('title','body','slug')->orderBy('id','desc')->first());
        });
        view()->composer(['categories','posts','post','postCreate','page'], function ($view) {
            $view->with('ads' , Website_content::where('area_id',15)->pluck('value','link'));
        });
    }
}
