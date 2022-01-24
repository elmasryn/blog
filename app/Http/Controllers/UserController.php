<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render(adminview('users'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles  = Role::pluck('name', 'id');
        return view(adminview('users_create'), compact('roles'));
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
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:6',
            'role'      => ['nullable', 'exists:roles,id'],
            'fav_lang'  => 'nullable',
            'about'     => 'nullable',
            'image'     => 'nullable|image|mimes:bmp,gif,jp2,jpeg,jpg,jpe,png|max:2048',
        ], [], [
            'role'      => trans('lang.Status'),
            'fav_lang'  => trans('lang.Favorite language'),
            'about'     => trans('lang.About user'),
            'image'     => trans('lang.Image'),
        ]);

        $newUser = new User;

        $newUser->name              = $data['name'];
        $newUser->email             = $data['email'];
        $newUser->password          = Hash::make($data['password']);
        $newUser->save();

        $newUserProfile = new \App\Profile([
            'lang' => $data['fav_lang'],
            'about' => $data['about'],
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            if (!in_array('image', Storage::directories()))
                Storage::makeDirectory('image');
            // for inside filesystems
            Image::make($request->file('image'))->resize(183, 183)
                ->save(public_path('img/image/' . $imageName));
            $newUserProfile->setAttribute('avatar', 'img/image/' . $imageName);
            // for public (storage) filesystems
            // Image::make($request->file('image'))->resize(183, 183)
            //     ->save(public_path('storage/image/' . $imageName));
            // $newUserProfile->setAttribute('avatar', 'storage/image/' . $imageName);
        }

        if ($newUser->profile()->save($newUserProfile)) {
            $newUser->roles()->attach($data['role']);
            return redirect(adminurl('users'))->with('success', trans('lang.The User has been stored successfully'));
        }
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
        $user   = User::with('profile', 'roles')->findOrFail($id);
        $roles  = Role::pluck('name', 'id');
        return view(adminview('users_edit'), compact('user', 'roles'));
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
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users.id',
            'email'     => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'password'  => 'sometimes|nullable|string|min:6',
            'role'      => ['nullable', 'exists:roles,id'],
            'fav_lang'  => 'nullable',
            'about'     => 'nullable',
            'image'     => 'nullable|image|mimes:bmp,gif,jp2,jpeg,jpg,jpe,png|max:2048',
        ], [], [
            'role'      => trans('lang.Status'),
            'fav_lang'  => trans('lang.Favorite language'),
            'about'     => trans('lang.About user'),
            'image'     => trans('lang.Image'),
        ]);

        $editUser = User::with('profile')->findOrFail($id);
        $editUser->name             = $data['name'];
        $editUser->email            = $data['email'];
        $editUser->profile->lang    = $data['fav_lang'];
        $editUser->profile->about   = $data['about'];

        if ($request->password != Null)
            $editUser->password     = Hash::make($data['password']);


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
            $editUser->roles()->sync($data['role']);
            if ($editUser->id == $request->user()->id) {
                if (array_key_exists($data['fav_lang'], locales()))
                    session(['locale' => $data['fav_lang']]);
            }
            return redirect(adminurl('users'))->with('success', trans('lang.The User has been updated successfully'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteUser = User::where('id', '!=', '1')->findOrFail($id);
        if (isset($deleteUser->profile->avatar)) {
            $currentLocationImgAsArray = explode('/', $deleteUser->profile->avatar);
            if(Str::length(end($currentLocationImgAsArray)) > 5)
                Storage::delete('image/' . end($currentLocationImgAsArray));
        }
        if ($deleteUser->delete())
            return back()->with('success', trans('lang.The User has been deleted successfully'));
    }

    public function multidestroy()
    {
        $checked = request('checked');
        if ($checked > 0) {
            $users = User::with('profile')->where('id', '!=', '1')->whereIn('id', $checked);
            foreach ($users->get() as $user) {
                if (isset($user->profile->avatar)) {
                    $currentLocationImgAsArray = explode('/', $user->profile->avatar);
                    if(Str::length(end($currentLocationImgAsArray)) > 5)
                        Storage::delete('image/' . end($currentLocationImgAsArray));
                }
            }
            if ($users->delete())
                return back()->with('success', trans('lang.Data has been deleted successfully'));
        } else
            return back()->with('error', trans('lang.Please choose some records to delete'));
    }
}
