<?php

namespace App\Http\Controllers;

use App\DataTables\PostsDataTable;
use App\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PostsDataTable $dataTable)
    {
        return $dataTable->render(adminview('posts'));
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
        if ($deletePost->delete()) {
            if ($deletePost->tags->count() > 0) {
                foreach ($deletePost->tags as $tag) {
                    if ($tag->posts->count() < 2)
                        $tag->delete();
                }
            }
            if (isset($deletePost->thumbnail)) {
                $currentLocationImgAsArray = explode('/', $deletePost->thumbnail);
                if(Str::length(end($currentLocationImgAsArray)) > 5)
                    Storage::delete('thumbnail/' . end($currentLocationImgAsArray));
            }
            return back()->with('success', trans('lang.The Post has been deleted successfully'));
        }
    }

    public function multidestroy()
    {
        $checked = request('checked');
        if ($checked > 0) {
            $posts = Post::with('tags:id')->whereIn('id', $checked);
            if ($posts) {

                foreach ($posts->get() as $post) {
                    if ($post->tags->count() > 0) {
                        foreach ($post->tags as $tag) {
                            if ($tag->posts->count() < 2)
                                $tag->delete();
                        }
                    }

                    if (isset($post->thumbnail)) {
                        $currentLocationImgAsArray = explode('/', $post->thumbnail);
                        if(Str::length(end($currentLocationImgAsArray)) > 5)
                            Storage::delete('thumbnail/' . end($currentLocationImgAsArray));
                    }
                }
                if ($posts->delete())
                    return back()->with('success', trans('lang.Data has been deleted successfully'));
            }
        } else
            return back()->with('error', trans('lang.Please choose some records to delete'));
    }
}
