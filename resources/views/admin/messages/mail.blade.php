@extends('admin.messages.messages')
@section('title' , '| '.$mail->email)
@section('mailContent')
@section('breadcrumb')
<li class="breadcrumb-item active">{{ $mail->email }}</li>
@endsection

<div class="col-md-9">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <form action="{{route(adminview('messages.title') , $mail->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="title"></label>
                    <select class="custom-select" name="title" id="title" onchange="this.form.submit()">
                        @foreach ($message_titles as $message_title)
                        <option value="{{$message_title->id}}"
                            {{ $message_title->id == $mail->message_title->id ? "selected=selected" : "" }}>
                            {{ $message_title->{'title_'.app()->getLocale()} }}</option>
                        @endforeach
                    </select>
                </form>
            </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <div class="mailbox-read-info">
                <h5>{{__('lang.Sender')}} : {{ $mail->name }} <small>@if ($mail->user_id != Null) (<a
                            href="{{route('profile.show',$mail->user_id)}}">{{__('lang.Registered')}}</a>)
                        @endif</small></h5>
                <h6>{{__('lang.Email')}} : {{ $mail->email }}
                    <span class="mailbox-read-time float-right">{{__('lang.Created at')}} :
                        {{ $mail->created_at->format('j M. Y h:i A') }}</span>
                </h6>
            </div>
            <!-- /.mailbox-read-info -->
            <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-container="body"
                        title="Delete" data-target="#del_mail{{ $mail->id }}"><i class="far fa-trash-alt"></i></button>
                    <!-- /.btn-group -->
                    <button onClick="window.print()" type="button" class="btn btn-primary btn-sm" data-toggle="tooltip"
                        title="Print">
                        <i class="fas fa-print"></i></button>
                </div>
                <!-- /.mailbox-controls -->
                <div class="mailbox-read-message m-3 text-left">
                    {{ $mail->body }}
                </div>
                <!-- /.mailbox-read-message -->
            </div>
            <!-- /.card-body -->

            <div class="card-footer">

                <div class="float-right">
                    @if ($mail->trashed())
                    <button type="button" data-toggle="modal" data-target="#restore_mail{{ $mail->id }}"
                        class="btn btn-success"><i class="fas fa-share"></i> {{__('lang.Restore the trash')}}
                    </button>
                    @include('admin.messages.restore')
                    @endif

                    @if (!$mail->trashed() && $mail->read == 'old')
                    <button type="button" data-toggle="modal" data-target="#mark_mail{{ $mail->id }}"
                        class="btn btn-success"><i class="far fa-envelope-open"></i> {{__('lang.Mark as unread')}}
                    </button>
                    @include('admin.messages.mark')
                    @endif
                </div>

                <button type="button" data-toggle="modal" data-target="#del_mail{{ $mail->id }}" class=" btn
                    btn-danger"><i class="far fa-trash-alt"></i> {{__('lang.Delete')}}
                </button>
                @include('admin.messages.del_mail')

                <button onClick="window.print()" type="button" class="btn btn-primary"><i class="fas fa-print"></i>
                    {{__('lang.Print')}}</button>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->


    @push('js')
    <script>

    </script>
    @endpush


    @endsection