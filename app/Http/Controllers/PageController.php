<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\PagesDataTable;
use App\Page;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PagesDataTable $dataTable)
    {
        return $dataTable->render(adminview('pages'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(adminview('pages_create'));
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
            'title_en' => 'required_without:title_ar|max:255',
            'title_ar' => 'required_without:title_en|max:255',
            'body'     => 'required|min:3',
            'status'   => ['nullable', Rule::in(['0', '1'])],
        ], [], [
            'title_en' => trans('lang.Title page name by English'),
            'title_ar' => trans('lang.Title page name by Arabic'),
            'body'     => trans('lang.Body'),
            'status'   => trans('lang.Status'),
        ]);
        $newPage = new Page();
        if ($data['title_en'] == Null)
            $newPage->title_en = $data['title_ar'];
        else
            $newPage->title_en = $data['title_en'];

        if ($data['title_ar'] == Null)
            $newPage->title_ar = $data['title_en'];
        else
            $newPage->title_ar = $data['title_ar'];

        $newPage->body      = $data['body'];
        $newPage->status    = $data['status'];

        $slug = Str::slug($newPage->title_en, '-');
        $count = $newPage->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $checkSlugs = Page::where('slug', "{$slug}-{$count}")->first();
        if ($checkSlugs === Null)
            $newPage->slug = $count ? "{$slug}-{$count}" : $slug;
        else
            $newPage->slug = "{$slug}-{$count}" . time();

        if ($newPage->save())
            return redirect(adminurl('pages'))->with('success', trans('lang.The Page has been stored successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view(adminview('pages_edit'), compact('page'));
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
            'title_en' => 'required|max:255',
            'title_ar' => 'required|max:255',
            'body'     => 'required|min:3',
            'status'   => ['nullable', Rule::in(['0', '1'])],
        ], [], [
            'title_en' => trans('lang.Title page name by English'),
            'title_ar' => trans('lang.Title page name by Arabic'),
            'body'     => trans('lang.Body'),
            'status'   => trans('lang.Status'),
        ]);

        $editPage = Page::findOrFail($id);
        if ($data['title_en'] == $editPage->title_en)
            $isSlugChanged = 'no';
        else
            $isSlugChanged = 'yes';

        $editPage->title_en = $data['title_en'];
        $editPage->title_ar = $data['title_ar'];
        $editPage->body     = $data['body'];
        $editPage->status   = $data['status'];

        if ($isSlugChanged == 'yes') {
            $slug       = Str::slug($editPage->title_en, '-');
            $count      = Page::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->where('id', '!=', $id)->count();
            $checkSlugs = Page::where('slug', "{$slug}-{$count}")->first();

            if ($checkSlugs === Null)
                $editPage->slug = $count ? "{$slug}-{$count}" : $slug;
            else
                $editPage->slug = "{$slug}-{$count}" . time();
        }

        if ($editPage->save())
            return redirect(adminurl('pages'))->with('success', trans('lang.The Page has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletePage = Page::findOrFail($id);
        if ($deletePage->delete())
            return back()->with('success', trans('lang.The Page has been deleted successfully'));
    }

    public function multidestroy()
    {
        $checked = request('checked');
        if ($checked > 0) {
            $pages = Page::whereIn('id', $checked);
            if ($pages->delete())
                return back()->with('success', trans('lang.Data has been deleted successfully'));
        } else
            return back()->with('error', trans('lang.Please choose some records to delete'));
    }
}
