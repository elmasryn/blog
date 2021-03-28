<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\TagsDataTable;
use App\Tag;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TagsDataTable $dataTable)
    {
        return $dataTable->render(adminview('tags'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(adminview('tags_create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ], [], [
            'name' => trans('lang.Tag name'),
        ]);
        $newTag         = new Tag();
        $newTag->name   = $data['name'];

        $slug = Str::slug($newTag->name, '-');
        $count = $newTag->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $checkSlugs = Tag::where('slug', "{$slug}-{$count}")->first();
        if($checkSlugs === Null)
            $newTag->slug = $count ? "{$slug}-{$count}" : $slug;
        else
            $newTag->slug = "{$slug}-{$count}".time();

        if ($newTag->save())
            return redirect(adminurl('tags'))->with('success', trans('lang.The Tag has been stored successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        return view(adminview('tags_edit'), compact('tag'));
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
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ], [], [
            'name' => trans('lang.Tag name'),
        ]);
        $editTag       = Tag::findOrFail($id);
        $editTag->name = $data['name'];

        $slug       = Str::slug($editTag->name, '-');
        $count      = Tag::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->where('id', '!=', $id)->count();
        $checkSlugs = Tag::where('slug', "{$slug}-{$count}")->first();

        if($checkSlugs === Null)
            $editTag->slug = $count ? "{$slug}-{$count}" : $slug;
        else
            $editTag->slug = "{$slug}-{$count}".time();

        if ($editTag->save())
            return redirect(adminurl('tags'))->with('success', trans('lang.The Tag has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteTag = Tag::findOrFail($id);
        if ($deleteTag->delete())
            return back()->with('success', trans('lang.The Tag has been deleted successfully'));
    }

    public function multidestroy()
    {
        $checked = request('checked');
        if ($checked > 0) {
            $tags = Tag::whereIn('id', $checked);
            if ($tags->delete())
                return back()->with('success', trans('lang.Data has been deleted successfully'));
        } else
            return back()->with('error', trans('lang.Please choose some records to delete'));
    }
}
