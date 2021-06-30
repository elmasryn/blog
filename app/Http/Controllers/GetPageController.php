<?php

namespace App\Http\Controllers;

use App\Category;
use App\Page;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class GetPageController extends Controller
{


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        if (auth()->check() && count(auth()->user()->roles->pluck('name')->intersect('Admin')) > 0)
            $id   = Page::where('slug', $slug)->pluck('id')->first();
        else
            $id   = Page::where(['slug' => $slug, 'status' => '1'])->pluck('id')->first();

        $page = Page::select('id', 'title_en', 'title_ar', 'body', 'slug', 'created_at', 'updated_at')
            ->findOrFail($id);

        $mostTags = Tag::withCount('posts')->orderBy('posts_count', 'desc')->take(35)->get();

        $keyword = [];
        foreach ($mostTags->pluck('name') as $relatedTag) {
            $keyword[] = $relatedTag;
        }
        $keywords = implode(', ', $keyword);

        $allPages   = Page::where('status', '1')->select('title_en', 'title_ar', 'slug')->where('id', '!=', $id)->get();

        $allCategories = Category::select('title_en', 'title_ar', 'slug')->get();
        return view('page', compact('page', 'allPages', 'mostTags', 'allCategories', 'keywords'));
    }
}
