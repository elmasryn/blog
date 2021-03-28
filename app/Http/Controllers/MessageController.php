<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Message_title;
use App\User;

class MessageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session()->flash('backUrl', Request()->fullUrl());
        $paginationCount = auth()->user()->profile->pagination;
        $messages = Message::orderBy('id', 'desc')->paginate($paginationCount);
        if (count($messages) > 1) {
            $since = mailSince($messages);
            return view(adminview('messages.inbox'), compact('messages', 'since', 'paginationCount'));
        } else {
            return view(adminview('messages.inbox'), compact('messages'));
        }
    }

    public function unreadMessages()
    {
        Session()->flash('backUrl', Request()->fullUrl());
        $paginationCount = auth()->user()->profile->pagination;
        $unreadMessages = Message::where('read', 'new')->orderBy('updated_at', 'desc')->paginate($paginationCount);
        if (count($unreadMessages) > 1) {
            $since = mailSince($unreadMessages);
            return view(adminview('messages.unread'), compact('since', 'unreadMessages', 'paginationCount'));
        } else {
            return view(adminview('messages.unread'), compact('unreadMessages'));
        }
    }

    public function readMessages()
    {
        Session()->flash('backUrl', Request()->fullUrl());
        $paginationCount = auth()->user()->profile->pagination;
        $readMessages = Message::where('read', 'old')->orderBy('id', 'desc')->paginate($paginationCount);
        if (count($readMessages) > 1) {
            $since = mailSince($readMessages);
            return view(adminview('messages.read'), compact('since', 'readMessages','paginationCount'));
        } else {
            return view(adminview('messages.read'), compact('readMessages'));
        }
    }

    public function trashMessages()
    {
        Session()->flash('backUrl', Request()->fullUrl());
        $paginationCount = auth()->user()->profile->pagination;
        $trashMessages = Message::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate($paginationCount);
        if (count($trashMessages) > 1) {
            $since = mailSince($trashMessages);
            return view(adminview('messages.trash'), compact('since', 'trashMessages','paginationCount'));
        } else {
            return view(adminview('messages.trash'), compact('trashMessages'));
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (session()->has('backUrl')) {
            session()->keep('backUrl');
        }
        $message_titles = Message_title::all();
        $mail = Message::with('message_title')->withTrashed()->findOrFail($id);
        $mail->read = 'old';
        $mail->save();
        return view(adminview('messages.mail'), compact('mail','message_titles'));
    }


    public function title(Request $request, $id)
    {
        $updateMailTitle = Message::findOrFail($id);
        $updateMailTitle->title_id = $request->title;
        if ($updateMailTitle->save()) {
            $titleName = $updateMailTitle->message_title->{'title_' . app()->getLocale()};
            return back()->with('success', trans_choice('lang.The Mail has been transfered successfully', $titleName, ['department' => $titleName]));
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
        $mail = Message::withTrashed()->findOrFail($id);
        if ($mail->trashed()) {
            if ($mail->forceDelete()) {
                if (session()->has('backUrl'))
                    return ($url = session()->get('backUrl'))
                        ? redirect($url)->with('success', trans('lang.The Mail has been deleted successfully'))
                        : redirect(adminurl('messages'))->with('success', trans('lang.The Mail has been deleted successfully'));
                else
                    return redirect(adminurl('messages'))->with('success', trans('lang.The Mail has been deleted successfully'));
            }
        } else {
            if ($mail->delete()) {
                if (session()->has('backUrl'))
                    return ($url = session()->get('backUrl'))
                        ? redirect($url)->with('success', trans('lang.The Mail has been deleted successfully'))
                        : redirect(adminurl('messages'))->with('success', trans('lang.The Mail has been deleted successfully'));
                else
                    return redirect(adminurl('messages'))->with('success', trans('lang.The Mail has been deleted successfully'));
            }
        }
    }


    public function restore($id)
    {
        $mail = Message::withTrashed()->findOrFail($id);
        if ($mail->restore())
            return back()->with('success', trans('lang.Mail has been restored successfully'));
    }


    public function mark($id)
    {
        $mail = Message::findOrFail($id);
        $mail->read = 'new';
        if ($mail->save()) {
            if (session()->has('backUrl'))
                return ($url = session()->get('backUrl'))
                    ? redirect($url)->with('success', trans('lang.The Mail has been updated successfully'))
                    : redirect(adminurl('messages'))->with('success', trans('lang.The Mail has been updated successfully'));
            else
                return redirect(adminurl('messages'))->with('success', trans('lang.The Mail has been updated successfully'));
        }
    }


    public function multidestroy()
    {
        if (request()->has('destroy')) {
            $checked = request('checked');
            if ($checked > 0) {
                $messages = Message::whereIn('id', $checked);
                if ($messages->delete())
                    return back()->with('success', trans('lang.Data has been deleted successfully'));
            } else {
                return back()->with('error', trans('lang.Please choose some records to delete'));
            }
        }
    }

    public function multiForcedestroy()
    {
        if (request()->has('force')) {
            $checked = request('checked');
            if ($checked > 0) {
                $messages = Message::whereIn('id', $checked);
                if ($messages->forceDelete())
                    return back()->with('success', trans('lang.Data has been deleted successfully'));
            } else {
                return back()->with('error', trans('lang.Please choose some records to delete'));
            }
        }
    }

    public function multiRestore()
    {
        if (request()->has('restore')) {
            $checked = request('checked');
            if ($checked > 0) {
                $messages = Message::whereIn('id', $checked);
                if ($messages->restore())
                    return back()->with('success', trans('lang.Data has been restored successfully'));
            } else {
                return back()->with('error', trans('lang.Please choose some records to restore'));
            }
        }
    }

    public function multiMark()
    {
        if (request()->has('mark')) {
            $checked = request('checked');
            if ($checked > 0) {
                $messages = Message::whereIn('id', $checked);
                if ($messages->update(['read' => 'new']))
                    return back()->with('success', trans('lang.Data has been updated successfully'));
            } else {
                return back()->with('error', trans('lang.Please choose some records to update'));
            }
        }
    }

    public function pagination(Request $request, $id)
    {
        if ($request->has('pagination')) {
            $updateUser = User::findOrFail($id);
            $updateUser->profile->pagination = $request->pagination;
            if ($updateUser->profile->save())
                return back()->with('success', trans('lang.Data has been updated successfully'));
        }
    }
}
