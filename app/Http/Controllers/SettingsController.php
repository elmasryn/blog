<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
    public function show()
    {
        return view(adminview('settings'));
    }



    public function update(request $request)
    {
        $data = $request->validate([
            'website_en'        => 'nullable|max:255',
            'website_ar'        => 'nullable|max:255',
            'default_lang'      => 'nullable',
            'email'             => 'nullable|email',
            'description'       => 'nullable',
            'keywords'          => 'nullable',
            'icon'              => 'nullable|image|mimes:bmp,gif,jp2,jpeg,jpg,jpe,png|max:2048',
            'post_publish_status'    => 'boolean',
            'comment_publish_status' => 'boolean',
            'comment_status'    => 'boolean',
            'comment_message'   => 'nullable',
            'website_status'    => 'boolean',
            'website_message'   => 'nullable',
        ], [], [
            'website_en'        => trans('lang.Website name by English'),
            'website_ar'        => trans('lang.Website name by Arabic'),
            'default_lang'      => trans('lang.Default language'),
            'email'             => trans('lang.Email'),
            'description'       => trans('lang.Description'),
            'keywords'          => trans('lang.Keywords'),
            'icon'              => trans('lang.Website icon'),
            'post_publish_status'    => trans('lang.Post directly published'),
            'comment_publish_status' => trans('lang.Comment directly published'),
            'comment_status'    => trans('lang.Comment status'),
            'comment_message'   => trans('lang.Message for closed comments'),
            'website_status'    => trans('lang.Website status'),
            'website_message'   => trans('lang.Message for closed Website'),
        ]);
        $newSetting = Setting::first() ?? Setting::create();
        $newSetting->website_en         = $data['website_en'];
        $newSetting->website_ar         = $data['website_ar'];
        $newSetting->default_lang       = $data['default_lang'];
        $newSetting->email              = $data['email'];
        $newSetting->description        = $data['description'];
        $newSetting->keywords           = $data['keywords'];
        $newSetting->post_publish_status    = $data['post_publish_status'];
        $newSetting->comment_publish_status = $data['comment_publish_status'];
        $newSetting->comment_status     = $data['comment_status'];
        $newSetting->comment_status == 0 ? $newSetting->comment_message = $data['comment_message'] : '';
        $newSetting->website_status     = $data['website_status'];
        $newSetting->website_status == 0 ? $newSetting->website_message = $data['website_message'] : '';


        if ($request->hasFile('icon')) {
            $imageName = time() . '.' . $request->icon->extension();
            $currentLocationImgAsArray = explode('/', setting()->icon);
            Storage::delete('icon/' . end($currentLocationImgAsArray));
            if (!in_array('icon', Storage::directories()))
                Storage::makeDirectory('icon');
            Image::make($request->file('icon'))->resize(40, 40)
                ->save(public_path('storage/icon/' . $imageName));
            $newSetting->icon = 'storage/icon/' . $imageName;
        }

        if ($newSetting->save())
            return back()->with('success', trans('lang.Data has been updated successfully'));
    }
}
