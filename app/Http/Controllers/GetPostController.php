<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Post;
use App\Tag;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class GetPostController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:Admin')->only('destroyComment', 'publishComment', 'publishPost');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request('category')) {

            $category = Category::select('id', 'title_en', 'title_ar', 'desc_en', 'desc_ar')->where('slug', request('category'))->firstOrFail();
            $posts    = Post::with(['user:id,name', 'tags:name,slug'])
                ->select('id', 'title', 'body', 'slug', 'thumbnail', 'created_at', 'user_id', 'category_id')
                ->withCount(['comments' => function ($query) {
                    $query->where('status', '1');
                }])
                ->where(['status' => '1', 'category_id' => $category->id])
                ->orderBy('id', 'desc')
                ->pagination();

            $relatedTags   = Tag::select('name', 'slug')->whereHas('posts.category', function ($query) {
                $query->where('slug', request('category'));
            })
                ->take(35)->get();

            $keyword = [];
            foreach ($relatedTags->pluck('name') as $relatedTag) {
                $keyword[] = $relatedTag;
            }
            $keywords = implode(', ', $keyword);
            $tag = '';
        } elseif (request('tag')) {

            $tag   = Tag::select('id', 'name')->where('slug', request('tag'))->firstOrFail();

            $posts = Post::with(['user:id,name', 'tags:name,slug', 'category:id,title_en,title_ar'])
                ->select('id', 'title', 'body', 'slug', 'thumbnail', 'created_at', 'user_id', 'category_id')
                ->withCount(['comments' => function ($query) {
                    $query->where('status', '1');
                }])
                ->where('status', '1')
                ->whereHas('tags', function ($query) use ($tag) {
                    $query->where('id', $tag->id);
                })
                ->orderBy('id', 'desc')
                ->pagination(4);

            $relatedTags   = Tag::select('name', 'slug')->whereHas('posts.tags', function ($query) {
                $query->where('slug', request('tag'));
            })->take(35)->get();

            $keyword = [];
            foreach ($relatedTags->pluck('name') as $relatedTag) {
                $keyword[] = $relatedTag;
            }
            $keywords = implode(', ', $keyword);
            $category = '';
        } else {

            $posts  = Post::with(['user:id,name', 'tags:name,slug', 'category:id,title_en,title_ar'])
                ->select('id', 'title', 'body', 'slug', 'thumbnail', 'created_at', 'user_id', 'category_id')
                ->withCount(['comments' => function ($query) {
                    $query->where('status', '1');
                }])
                ->where('status', '1')
                ->orderBy('id', 'desc')
                ->pagination();

            $relatedTags   = Tag::select('name', 'slug')->withCount('posts')->orderBy('posts_count', 'desc')->take(35)->get();

            $keyword = [];
            foreach ($relatedTags->pluck('name') as $relatedTag) {
                $keyword[] = $relatedTag;
            }
            $keywords = implode(', ', $keyword);
            $category = '';
            $tag = '';
        }

        $allCategories = Category::select('title_en', 'title_ar', 'slug')->get();

        return view('posts', compact('posts', 'relatedTags', 'allCategories', 'keywords', 'category', 'tag'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::any(['admin', 'editor'])) {
            $allCategories = Category::select('id', 'title_en', 'title_ar', 'slug')->get();
            $mostTags      = Tag::withCount('posts')->orderBy('posts_count', 'desc')->take(35)->get();
            $allTags       = Tag::pluck('name', 'id');

            return view('postCreate', compact('allCategories', 'mostTags', 'allTags'));
        } else
            abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd(storage_path('thumbnail'));
        if (Gate::any(['admin', 'editor'])) {
            $data = $request->validate([
                'title'     => 'required|min:3|max:255',
                'body'      => 'required|min:3',
                'category'  => ['required', 'exists:categories,id'],
                'status'    => ['nullable', Rule::in(['0', '1'])],
                'thumbnail' => 'nullable|image|mimes:bmp,gif,jp2,jpeg,jpg,jpe,png|max:2048',
                'tags'      => 'required|array|max:255',
            ], [], [
                'title'     => trans('lang.Post title'),
                'body'      => trans('lang.Body'),
                'category'  => trans('lang.The Category'),
                'status'    => trans('lang.Status'),
                'thumbnail' => trans('lang.Image'),
                'tags'      => trans('lang.The tags'),
            ]);
            $newPost = new Post();
            $newPost->title       = $data['title'];
            $newPost->body        = $data['body'];
            $newPost->category_id = $data['category'];
            $newPost->user_id     = auth()->id();

            if (count(auth()->user()->roles->pluck('name')->intersect('Admin')) > 0)
                $newPost->status      = $data['status'];

            if (
                setting()->post_publish_status == 0 && auth()->check() &&
                count(auth()->user()->roles->pluck('name')->intersect('Admin')) == 0
            )
                $newPost->status = '0';

            $slug = Str::slug($newPost->title, '-');
            $count = $newPost->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $checkSlugs = Post::where('slug', "{$slug}-{$count}")->first();
            if ($checkSlugs === Null)
                $newPost->slug = $count ? "{$slug}-{$count}" : $slug;
            else
                $newPost->slug = "{$slug}-{$count}" . time();

            if ($request->hasFile('thumbnail')) {
                $thumbnailName = time() . '.' . $request->thumbnail->getClientOriginalExtension();
                if (!in_array('thumbnail', Storage::directories()))
                    Storage::makeDirectory('thumbnail');
                Image::make($request->file('thumbnail'))->resize(1280, 800)
                    ->save(public_path('storage/thumbnail/' . $thumbnailName));
                $newPost->thumbnail = 'storage/thumbnail/' . $thumbnailName;
            }

            $tagIds = [];
            foreach ($data['tags'] as $tagName) {
                $newTag = Tag::firstOrNew(['name' => strtolower(trim($tagName))]);
                // $newTag->name   = strtolower(trim($tagName));
                if (Tag::where('name', $newTag->name)->first() === Null) {
                    $tagSlug = Str::slug($newTag->name, '-');
                    $tagCount = $newTag->whereRaw("slug RLIKE '^{$tagSlug}(-[0-9]+)?$'")->count();
                    $checkTagSlugs = Tag::where('slug', "{$tagSlug}-{$tagCount}")->first();
                    if ($checkTagSlugs === Null)
                        $newTag->slug = $tagCount ? "{$tagSlug}-{$tagCount}" : $tagSlug;
                    else
                        $newTag->slug = "{$tagSlug}-{$tagCount}" . time();
                }

                if ($newTag->save())
                    $tagIds[] = $newTag->id;
            }

            if ($newPost->save()) {
                $newPost->tags()->sync($tagIds);
                return redirect(url('posts/' . $newPost->slug))->with('success', trans('lang.The Post has been stored successfully'));
            }
        } else
            abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        if (auth()->check() && count(auth()->user()->roles->pluck('name')->intersect('Admin')) > 0) {
            $id   = Post::withoutGlobalScope('status')->where('slug', $slug)->pluck('id')->first();
            $post = Post::withoutGlobalScope('status')->with(['user:id,name', 'tags:name,slug', 'category' => function ($query) {
                $query->withoutGlobalScope('status')->select('id', 'title_en', 'title_ar', 'slug');
            }])
                ->select('id', 'title', 'body', 'slug', 'thumbnail', 'status', 'created_at', 'user_id', 'category_id', 'updated_at')
                ->findOrFail($id);
        } else {
            $id   = Post::where('slug', $slug)->pluck('id')->first();
            $post = Post::with(['user:id,name', 'tags:name,slug', 'category:id,title_en,title_ar,slug'])
                ->select('id', 'title', 'body', 'slug', 'thumbnail', 'status', 'created_at', 'user_id', 'category_id', 'updated_at')
                ->findOrFail($id);
        }


        if (
            $post->getRawOriginal('status') == '1'
            or (auth()->check() && $post->getRawOriginal('status') == '0' && $post->user_id == auth()->id())
            or (auth()->check() && $post->getRawOriginal('status') == '0' && count(auth()->user()->roles->pluck('name')->intersect('Admin')) > 0)
        ) {

            $tags = $post->tags->pluck('slug', 'name');

            $relatedPosts   = Post::with('tags:name,slug')
                ->where('id', '!=', $id)
                ->where('status', '1')
                ->select('id', 'title', 'slug')
                ->whereHas('tags', function ($query) use ($tags) {
                    $query->whereIn('slug', $tags);
                })->take(10)->get();

            $relatedTags = [];
            foreach ($relatedPosts as $relatedPost) {
                foreach ($relatedPost->tags->pluck('name', 'slug') as $tagSlug => $tagName) {
                    $relatedTags[$tagSlug] = $tagName;
                }
            };
            $relatedTags = array_unique($relatedTags);

            $keywords = implode(', ', $relatedTags);

            ////////////////////////////// Start show Comment //////////////////////////////////////

            if (setting()->comment_status == '1') {
                $comments = Comment::with(['user' => function ($query) {
                    $query->with(['profile:id,user_id,avatar'])->select('id', 'name');
                }])
                    ->select('id', 'post_id', 'user_id', 'body', 'name', 'cookie', 'status', 'created_at', 'updated_at')
                    ->orderBy('id', 'desc');

                if (auth()->check() && count(auth()->user()->roles->pluck('name')->intersect('Admin')) == 0)
                    $comments = $comments->where('post_id', $id)->where('user_id', auth()->id())
                        ->orWhere('post_id', $id)->where('status', '1')->pagination();
                elseif (auth()->guest() && request()->cookie('guestCookie'))
                    $comments = $comments->where('post_id', $id)->where('cookie', request()->cookie('guestCookie'))
                        ->orWhere('post_id', $id)->where('status', '1')->pagination();
                elseif (auth()->check() && count(auth()->user()->roles->pluck('name')->intersect('Admin')) > 0)
                    $comments = $comments->where('post_id', $id)->pagination();
                else
                    $comments = $comments->where('post_id', $id)->where('status', '1')->pagination();
            } else
                $comments = '';

            ////////////////////////////// End Show Comment //////////////////////////////////////

            $allCategories = Category::select('title_en', 'title_ar', 'slug')->get();
            return view('post', compact('post', 'relatedPosts', 'relatedTags', 'tags', 'allCategories', 'keywords', 'comments'));
        } else
            return abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editPost = Post::with('category', 'tags')->findOrFail($id);
        $allCategories = Category::select('id', 'title_en', 'title_ar', 'slug')->get();
        $mostTags      = Tag::withCount('posts')->orderBy('posts_count', 'desc')->take(35)->get();
        $allTags       = Tag::pluck('name', 'id');

        if (Gate::any(['admin', 'owner'], $editPost)) {
            return view('postEdit', compact('allCategories', 'mostTags', 'allTags', 'editPost'));
        } else
            return abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        if (Gate::any(['admin', 'ownerTime'])) {
        } else
            return abort(403);
        // $article = Article::findOrFail($id);
        // $article->update($request->all());
        // $article->tag()->sync((array)$request->input('tag'));

        // $data = $request->validate([
        //     'body' => 'required|string|min:3|max:1000',
        // ], [], [
        //     'body' => trans('lang.Body'),
        // ]);

        // $editComment = Comment::with('post:id,slug')->select('id', 'body', 'status', 'post_id', 'user_id', 'created_at')->findOrFail($id);
        // if (Gate::any(['admin', 'ownerTime'], $editComment)) {
        //     $editComment->body = $data['body'];
        //     if (
        //         setting()->comment_publish_status == 0 &&
        //         ((auth()->check() && count(auth()->user()->roles->pluck('name')->intersect('Admin')) == 0)
        //             or auth()->guest())
        //     )
        //         $editComment->status = '0';
        //     if ($editComment->save())
        //         return redirect(url('posts/' . $editComment->post->slug . '#comment' . $id))->with('success', trans('lang.The Comment has been updated successfully'));
        // }




        //     $data = $request->validate([
        //         'title_en' => 'required|max:255',
        //         'title_ar' => 'required|max:255',
        //         'body'     => 'required|min:3',
        //         'status'   => ['nullable', Rule::in(['0', '1'])],
        //     ], [], [
        //         'title_en' => trans('lang.Title page name by English'),
        //         'title_ar' => trans('lang.Title page name by Arabic'),
        //         'body'     => trans('lang.Body'),
        //         'status'   => trans('lang.Status'),
        //     ]);

        //     $editPage = Page::findOrFail($id);

        //     if ($data['title_en'] != $editPage->title_en)
        //         $isSlugChanged = 'yes';
        //     else
        //         $isSlugChanged = 'no';


        //     $editPage->title_en = $data['title_en'];
        //     $editPage->title_ar = $data['title_ar'];
        //     $editPage->body     = $data['body'];
        //     $editPage->status   = $data['status'];

        //     if ($isSlugChanged == 'yes') {
        //         $slug       = Str::slug($editPage->title_en, '-');
        //         $count      = Page::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->where('id', '!=', $id)->count();
        //         $checkSlugs = Page::where('slug', "{$slug}-{$count}")->first();

        //         if ($checkSlugs === Null)
        //             $editPage->slug = $count ? "{$slug}-{$count}" : $slug;
        //         else
        //             $editPage->slug = "{$slug}-{$count}" . time();
        //     }

        //     if ($editPage->save())
        //         return redirect(adminurl('pages'))->with('success', trans('lang.The Page has been updated successfully'));
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletePost = Post::with('tags:id')->findOrFail($id);
        if (Gate::any(['admin', 'ownerTime'], $deletePost)) {
            if ($deletePost->delete()) {
                if ($deletePost->tags->count() > 0) {
                    foreach ($deletePost->tags as $tag) {
                        if ($tag->posts->count() < 2)
                            $tag->delete();
                    }
                }
                if (isset($deletePost->thumbnail)) {
                    $currentLocationImgAsArray = explode('/', $deletePost->thumbnail);
                    Storage::delete('thumbnail/' . end($currentLocationImgAsArray));
                }
                return redirect(url('posts'))->with('success', trans('lang.The Post has been deleted successfully'));
            }
        } else
            return abort(403);
    }

    public function publishPost(Request $request)
    {
        if ($request->ajax() && $request->has('message')) {
            $data = $request->validate([
                'message' => ['nullable', Rule::in(['0', '1'])],
            ], [], [
                'message' => trans('lang.Status'),
            ]);

            $editPost = Post::findOrFail($request->id);
            if ($data['message'] == '1')
                $editPost->status = '0';
            else
                $editPost->status = '1';

            if ($editPost->save()) {
                $response = [
                    'message' => __('lang.The post now is') . ' ' . $editPost->status,
                    'status'  => 'success'
                ];
                return response()->json($response);
            }
        }
    }



    //////////////////////////////////////Comment functions/////////////////////////////////

    public function storeComment(Request $request, $post_id)
    {
        $data = $request->validate([
            'body' => 'required|string|min:3|max:1000',
            'name' => 'required|string|min:2|max:150',
        ], [], [
            'body' => trans('lang.Body'),
            'name' => trans('lang.Name'),
        ]);

        $newComment = new Comment;
        $newComment->body = $data['body'];
        $newComment->name = $data['name'];
        $newComment->user_id = auth()->id() ?? Null;
        $newComment->post_id = $post_id;

        if (
            setting()->comment_publish_status == 0 &&
            ((auth()->check() && count(auth()->user()->roles->pluck('name')->intersect('Admin')) == 0)
                or auth()->guest())
        )
            $newComment->status = '0';

        if (auth()->guest()) {
            $commentCookieValue = bcrypt(md5(uniqid(time(), true)));
            $commentcookie = cookie('guestCookie', $commentCookieValue, 1000000);
            $newComment->cookie = $commentCookieValue;
            if ($newComment->save())
                return redirect(url('posts/' . $newComment->post->slug . '#comment' . $newComment->id))->cookie($commentcookie)->with('success', trans('lang.The Comment has been stored successfully'));
        } else
        if ($newComment->save())
            return redirect(url('posts/' . $newComment->post->slug . '#comment' . $newComment->id))->with('success', trans('lang.The Comment has been stored successfully'));
    }

    public function publishComment(Request $request)
    {
        if ($request->ajax() && $request->has('message')) {
            $data = $request->validate([
                'message' => ['nullable', Rule::in(['0', '1'])],
            ], [], [
                'message' => trans('lang.Status'),
            ]);

            $editComment = Comment::findOrFail($request->id);
            if ($data['message'] == '1')
                $editComment->status = '0';
            else
                $editComment->status = '1';

            if ($editComment->save()) {
                $response = [
                    'message' => __('lang.The comment now is') . ' ' . $editComment->status,
                    'status'  => 'success'
                ];
                return response()->json($response);
            }
        }
    }

    public function editComment(Request $request, $id)
    {
        $data = $request->validate([
            'body' => 'required|string|min:3|max:1000',
        ], [], [
            'body' => trans('lang.Body'),
        ]);

        $editComment = Comment::with('post:id,slug')->select('id', 'body', 'status', 'post_id', 'user_id', 'created_at')->findOrFail($id);
        if (Gate::any(['admin', 'ownerTime'], $editComment)) {
            $editComment->body = $data['body'];
            if (
                setting()->comment_publish_status == 0 &&
                ((auth()->check() && count(auth()->user()->roles->pluck('name')->intersect('Admin')) == 0)
                    or auth()->guest())
            )
                $editComment->status = '0';
            if ($editComment->save())
                return redirect(url('posts/' . $editComment->post->slug . '#comment' . $id))->with('success', trans('lang.The Comment has been updated successfully'));
        }
    }

    public function destroyComment($id)
    {
        $deleteComment = Comment::with('post:id,slug')->findOrFail($id);
        if ($deleteComment->delete())
            return redirect(url('posts/' . $deleteComment->post->slug . '#comment-'))->with('success', trans('lang.The Comment has been deleted successfully'));
    }
}
