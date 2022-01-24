<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ProfileController extends Controller
{


    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user       = User::with('profile', 'roles')->findOrFail($id);
        $roleName   = $user->roles->map(function ($role) {
            return $role->name;
        })->implode(' & ');
        return view('profile', compact('user', 'roleName'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user       = User::with('profile', 'roles')->findOrFail($id);
        $roleName   = $user->roles->map(function ($role) {
            return $role->name;
        })->implode(' & ');
        if (Gate::any(['admin', 'owner'], $user->profile))
            return view('profileEdit', compact('user', 'roleName'));
        else
            return abort('403');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => ['required', 'string', 'email', Rule::unique('users')->ignore($id)],
            'fav_lang'  => 'nullable',
            'about'     => 'nullable',
            'image'     => 'nullable|image|mimes:bmp,gif,jp2,jpeg,jpg,jpe,png|max:2048',
        ], [], [
            'name'      => trans('lang.Name'),
            'email'     => trans('lang.Email'),
            'fav_lang'  => trans('lang.Favorite language'),
            'about'     => trans('lang.About me'),
            'image'     => trans('lang.Image'),
        ]);
        $editUser = User::with('profile')->findOrFail($id);
        if (Gate::any(['admin', 'owner'], $editUser->profile)) {
            $editUser->name           = $data['name'];
            $editUser->email          = $data['email'];
            $editUser->profile->lang  = $data['fav_lang'];
            $editUser->profile->about = $data['about'];

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                if (isset($editUser->profile->avatar)) {
                    $currentLocationImgAsArray = explode('/', $editUser->profile->avatar);
                    if(Str::length(end($currentLocationImgAsArray)) > 5)
                        Storage::delete('image/' . end($currentLocationImgAsArray));
                }
                if (!in_array('image', Storage::directories()))
                    Storage::makeDirectory('image');
                // for inside filesystems
                Image::make($request->file('image'))->resize(183, 183)
                    ->save(public_path('img/image/' . $imageName));
                $editUser->profile->avatar = 'img/image/' . $imageName;
                // for public (storage) filesystems    
                // Image::make($request->file('image'))->resize(183, 183)
                //     ->save(public_path('storage/image/' . $imageName));
                // $editUser->profile->avatar = 'storage/image/' . $imageName;
            }

            if ($editUser->push()) {
                if ($editUser->id == $request->user()->id) {
                    if (array_key_exists($data['fav_lang'], locales()))
                        session(['locale' => $data['fav_lang']]);
                }
                return back()->with('success', trans('lang.Data has been updated successfully'));
            }
        } else
            return abort('403');
    }

    public function password(Request $request, $id)
    {
        $data = $request->validate([
            'password' => 'required|string|confirmed|min:6',
        ], [], [
            'password' => trans('lang.Password'),
        ]);
        $editUser = User::findOrFail($id);
        if (Gate::any(['admin', 'owner'], $editUser->profile)) {
            $editUser->password = Hash::make($data['password']);

            if ($editUser->save())
                return back()->with('success', trans('lang.Password has been changed successfully'));
        } else
            return abort('403');
    }
}
