<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

class contactUsController extends Controller
{
    public function create()
    {
        return view('contactUs');
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
            'name'      => 'required|max:255',
            'email'     => 'required|email|max:255',
            'subject'   => 'required|exists:message_titles,id',
            'message'   => 'required|min:3',
        ], [], [
            'name'      => trans('lang.Name'),
            'email'     => trans('lang.Email'),
            'subject'   => trans('lang.Subject'),
            'message'   => trans('lang.Message text'),
        ]);
        $newMessage = new Message();
        $newMessage->user_id    = $request->user()->id ?? Null;
        $newMessage->name       = $data['name'];
        $newMessage->email      = $data['email'];
        $newMessage->title_id   = $data['subject'];
        $newMessage->body       = $data['message'];
        if ($newMessage->save())
            return back()->with('success', trans('lang.Mail has been sent successfully'));
    }
}
