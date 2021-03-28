<?php

namespace App\Http\Controllers;

use App\Category;
use App\Tag;

class GetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories    = Category::select('title_en','title_ar','desc_en','desc_ar','slug')->orderBy('id','desc')->pagination();
        $allCategories = Category::select('title_en','title_ar','slug')->get();
        $mostTags      = Tag::withCount('posts')->orderBy('posts_count', 'desc')->take(35)->get();

        $keyword = [];
            foreach ($mostTags->pluck('name') as $relatedTag) {
                $keyword[] = $relatedTag;
            }
            $keywords = implode(', ', $keyword);

        return view('categories', compact('categories','mostTags','allCategories','keywords'));
    }

    
}
