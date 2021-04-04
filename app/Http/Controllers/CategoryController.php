<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\CategoriesDataTable;
use App\Category;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoriesDataTable $dataTable)
    {
        return $dataTable->render(adminview('categories'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(adminview('categories_create'));
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
            'desc_en'  => 'nullable',
            'desc_ar'  => 'nullable',
            'status'   => ['nullable', Rule::in(['0', '1'])],
        ], [], [
            'title_en' => trans('lang.Title name by English'),
            'title_ar' => trans('lang.Title name by Arabic'),
            'desc_en'  => trans('lang.Desc name by English'),
            'desc_ar'  => trans('lang.Desc name by Arabic'),
            'status'   => trans('lang.Status'),
        ]);
        $newCategory = new Category();
        if ($data['title_en'] == Null)
            $newCategory->title_en = $data['title_ar'];
        else
            $newCategory->title_en = $data['title_en'];

        if ($data['title_ar'] == Null)
            $newCategory->title_ar = $data['title_en'];
        else
            $newCategory->title_ar = $data['title_ar'];

        $newCategory->desc_en   = $data['desc_en'];
        $newCategory->desc_ar   = $data['desc_ar'];
        $newCategory->status    = $data['status'];

        $slug = Str::slug($newCategory->title_en, '-');
        $count = $newCategory->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $checkSlugs = Category::where('slug', "{$slug}-{$count}")->first();
        if ($checkSlugs === Null)
            $newCategory->slug = $count ? "{$slug}-{$count}" : $slug;
        else
            $newCategory->slug = "{$slug}-{$count}" . time();

        if ($newCategory->save())
            return redirect(adminurl('categories'))->with('success', trans('lang.The Category has been stored successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view(adminview('categories_edit'), compact('category'));
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
            'desc_en'  => 'nullable',
            'desc_ar'  => 'nullable',
            'status'   => ['nullable', Rule::in(['0', '1'])],
        ], [], [
            'title_en' => trans('lang.Title name by English'),
            'title_ar' => trans('lang.Title name by Arabic'),
            'desc_en'  => trans('lang.Desc name by English'),
            'desc_ar'  => trans('lang.Desc name by Arabic'),
            'status'   => trans('lang.Status'),
        ]);
        $editCategory = Category::findOrFail($id);
        if ($data['title_en'] == $editCategory->title_en)
            $isSlugChanged = 'no';
        else
            $isSlugChanged = 'yes';

        $editCategory->title_en = $data['title_en'];
        $editCategory->title_ar = $data['title_ar'];
        $editCategory->desc_en  = $data['desc_en'];
        $editCategory->desc_ar  = $data['desc_ar'];
        $editCategory->status   = $data['status'];

        if ($isSlugChanged == 'yes') {
            $slug       = Str::slug($editCategory->title_en, '-');
            $count      = Category::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->where('id', '!=', $id)->count();
            $checkSlugs = Category::where('slug', "{$slug}-{$count}")->first();
            if ($checkSlugs === Null)
                $editCategory->slug = $count ? "{$slug}-{$count}" : $slug;
            else
                $editCategory->slug = "{$slug}-{$count}" . time();
        }
        if ($editCategory->save())
            return redirect(adminurl('categories'))->with('success', trans('lang.The Category has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteCategory = Category::findOrFail($id);
        if ($deleteCategory->delete())
            return back()->with('success', trans('lang.The Category has been deleted successfully'));
    }

    public function multidestroy()
    {
        $checked = request('checked');
        if ($checked > 0) {
            $categories = Category::whereIn('id', $checked);
            if ($categories->delete())
                return back()->with('success', trans('lang.Data has been deleted successfully'));
        } else
            return back()->with('error', trans('lang.Please choose some records to delete'));
    }
}
