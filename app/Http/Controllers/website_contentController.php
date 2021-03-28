<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\Website_contentsDataTable;
use App\Website_content;
use App\Website_content_area;

class Website_contentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Website_contentsDataTable $dataTable)
    {
        return $dataTable->render(adminview('website_contents'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Website_content_area::pluck('id','area');
        return view(adminview('website_contents_create'), compact('areas'));
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
            'value' => 'required_without:link',
            'link'  => 'required_without:value',
            'area'  => 'exists:website_content_areas,id',
        ], [], [
            'value' => trans('lang.Content value'),
            'link'  => trans('lang.Link'),
            'area'  => trans('lang.Content area'),
        ]);
        $newWebsite_content = new Website_content();
        $newWebsite_content->value    = $data['value'];
        $newWebsite_content->link     = $data['link'];
        $newWebsite_content->area_id  = $data['area'];

        if ($newWebsite_content->save())
            return redirect(adminurl('website_contents'))->with('success', trans('lang.The content has been stored successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $areas = Website_content_area::pluck('id','area');
        $website_content = Website_content::with('Website_content_area')->findOrFail($id);
        return view(adminview('website_contents_edit'), compact('website_content', 'areas'));
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
            'value' => 'required_without:link',
            'link'  => 'required_without:value',
            'area'  => 'exists:website_content_areas,id',
        ], [], [
            'value' => trans('lang.Content value'),
            'link'  => trans('lang.Link'),
            'area'  => trans('lang.Content area'),
        ]);
        $editWebsite_content = Website_content::findOrFail($id);
        $editWebsite_content->value    = $data['value'];
        $editWebsite_content->link     = $data['link'];
        $editWebsite_content->area_id  = $data['area'];

        if ($editWebsite_content->save())
            return redirect(adminurl('website_contents'))->with('success', trans('lang.The content has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteWebsite_content = Website_content::findOrFail($id);
        if ($deleteWebsite_content->delete())
            return back()->with('success', trans('lang.The content has been deleted successfully'));
    }

    public function multidestroy()
    {
        $checked = request('checked');
        if ($checked > 0) {
            $website_contents = Website_content::whereIn('id', $checked);
            if ($website_contents->delete())
                return back()->with('success', trans('lang.Data has been deleted successfully'));
        } else
            return back()->with('error', trans('lang.Please choose some records to delete'));
    }
}
