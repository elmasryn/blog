<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message_title;

class Message_titleController extends Controller
{

    public function index()
    {
        $message_titles = Message_title::all();
        return view(adminview('messages.edit_department') , compact('message_titles'));
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
            'title_en' => 'required|max:255',
            'title_ar' => 'required|max:255',
         ],[],[
             'title_en' => trans('lang.Title name by English'),
             'title_ar' => trans('lang.Title name by Arabic'),
        ]);
        $newTitle = new Message_title();
        $newTitle->title_en = $data['title_en'];
        $newTitle->title_ar = $data['title_ar'];
        if ($newTitle->save())
            return back()->with('success',trans('lang.Data has been updated successfully'));
    }
 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Session()->flash('backUrl', Request()->fullUrl());
        $message_title = Message_title::findOrFail($id)->{'title_'.app()->getLocale()};
        $paginationCount = auth()->user()->profile->pagination;
        $showMessagesInTitle = \App\Message::where('title_id' , $id)->orderBy('id', 'desc')->paginate($paginationCount);
        if (count($showMessagesInTitle) > 1) {
            $since = mailSince($showMessagesInTitle);
            return view(adminview('messages.messages_department') , compact('message_title', 'showMessagesInTitle','since','paginationCount'));
        }
        else {
            return view(adminview('messages.messages_department') , compact('message_title', 'showMessagesInTitle'));
        }

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
        $updateTitle = Message_title::findOrFail($id);
        $updateTitle->title_en = $request->title_en;
        $updateTitle->title_ar = $request->title_ar;
        if ($updateTitle->save())
            return back()->with('success',trans('lang.Data has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $deleteTitle = Message_title::findOrFail($id);
            if ($deleteTitle->delete())
                return back()->with('success',trans('lang.Data has been deleted successfully'));
    }
}
