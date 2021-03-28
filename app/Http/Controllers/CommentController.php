<?php

namespace App\Http\Controllers;

use App\DataTables\CommentsDataTable;
use App\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CommentsDataTable $dataTable)
    {
        return $dataTable->render(adminview('comments'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteComment = Comment::findOrFail($id);
        if ($deleteComment->delete())
            return back()->with('success', trans('lang.The Comment has been deleted successfully'));
    }

    public function multidestroy()
    {
        $checked = request('checked');
        if ($checked > 0) {
            $comments = Comment::whereIn('id', $checked);
            if ($comments->delete())
                return back()->with('success', trans('lang.Data has been deleted successfully'));
        } else
            return back()->with('error', trans('lang.Please choose some records to delete'));
    }
}
