@extends('admin.messages.messages')
@section('title' , '| '.__('lang.Inbox'))
@section('mailContent')
@section('breadcrumb')
<li class="breadcrumb-item active">{{ trans('lang.Inbox') }}</li>
@endsection

<div class="col-md-9">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">{{ __('lang.Inbox') }}</h3>
            @if(isset($messages) && count($messages) > 0)
            @include('admin.messages.block_search')
            @endif
        </div>
        <!-- /.card-header -->
        @if(isset($messages) && count($messages) > 0)
        <div class="card-body p-0">
            <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
                <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-sm delBtn"><i class="far fa-trash-alt"></i></button>
                </div>
                <!-- /.btn-group -->

                <button type="submit" class="btn btn-default btn-sm ml-3 markBtn"><i
                        class="far fa-envelope-open mr-1"></i>
                    {{__('lang.Mark as unread')}}
                </button>

                <button type="button" class="btn btn-default btn-sm refresh"><i class="fas fa-sync-alt"></i></button>

                <div class="d-inline-block">
                    <form action="{{route(adminview('messages.pagination'),auth()->id())}}" method="POST">
                        @csrf
                        @method('PUT')
                        <label for="pagination">{{ __('lang.Items will be shown in each page') }}</label>
                        <select class="custom-select w-50" name="pagination" id="pagination"
                            onchange="this.form.submit()">
                            <option value="{{Null}}" {{ $paginationCount == Null ? 'selected' : '' }}>
                                {{ __('lang.Choose number') }}</option>
                            <option value="5" {{ $paginationCount == "5" ? 'selected' : '' }}>5</option>
                            <option value="10" {{ $paginationCount == "10" ? 'selected' : '' }}>10</option>
                            <option value="20" {{ $paginationCount == "20" ? 'selected' : '' }}>20</option>
                            <option value="50" {{ $paginationCount == "50" ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $paginationCount == "100" ? 'selected' : '' }}>100</option>
                            <option value="200" {{ $paginationCount == "200" ? 'selected' : '' }}>200</option>
                            <option value="400" {{ $paginationCount == "400" ? 'selected' : '' }}>400</option>
                        </select>
                    </form>
                </div>

                <div class="float-right">
                    {{$messages->firstItem()}}-{{$messages->lastItem()}}/{{$messages->total()}}
                    <div class="btn-group">
                        <a type="button" href="{{$messages->nextPageUrl()}}"
                            class="btn btn-default btn-sm {{$messages->hasMorePages() ? '' : 'disabled'}}"><i
                                class="fas fa-chevron-left"></i></a>
                        <a type="button" href="{{$messages->previousPageUrl()}}"
                            class="btn btn-default btn-sm {{$messages->onFirstPage() ? 'disabled' : ''}}"><i
                                class="fas fa-chevron-right"></i></a>
                    </div>
                    <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
            </div>
            <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                    <tbody>
                        <form id="del_form" method="POST" action="messages/">
                            @csrf
                            @method('POST')
                            <input id="my_input" type="hidden" name="">
                            @foreach ($messages as $message)
                            <tr class="{{$message->read == 'new' ? 'table-warning' : ''}}">
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input item_checkbox"
                                            value="{{ $message->id }}" name="checked[]" id="check{{$message->id}}">
                                        <label class="custom-control-label" for="check{{$message->id}}"></label>
                                    </div>
                                </td>
                                <td class="mailbox-name">
                                    @isset($message->user_id)
                                    <a href="{{route('profile.show',$message->user_id)}}">{{$message->name}}
                                    </a>
                                    @endisset
                                    @empty($message->user_id)
                                    {{$message->name}}
                                    @endempty
                                </td>
                                <td class="mailbox-subject">
                                    <b><a class="text-dark"
                                            href="{{route(adminview('messages.show') , $message->id)}}">{{Str::limit($message->body , 55)}}</a></b>
                                </td>
                                <td class="mailbox-date">
                                    {{$since[$message->id]}}
                                </td>
                            </tr>
                            @include('admin.messages.del_multi')
                            @endforeach
                        </form>
                    </tbody>
                </table>
                <!-- /.table -->
            </div>
            <!-- /.mail-box-messages -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer p-0">
            <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
                <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-sm delBtn"><i class="far fa-trash-alt"></i></button>
                </div>
                <!-- /.btn-group -->

                <button type="submit" class="btn btn-default btn-sm ml-3 markBtn"><i
                        class="far fa-envelope-open mr-1"></i>
                    {{__('lang.Mark as unread')}}
                </button>

                <button type="button" class="btn btn-default btn-sm refresh"><i class="fas fa-sync-alt"></i></button>
                <div class="float-right">
                    {{$messages->firstItem()}}-{{$messages->lastItem()}}/{{$messages->total()}}
                    <div class="btn-group">
                        <a type="button" href="{{$messages->nextPageUrl()}}"
                            class="btn btn-default btn-sm {{$messages->hasMorePages() ? '' : 'disabled'}}"><i
                                class="fas fa-chevron-left"></i></a>
                        <a type="button" href="{{$messages->previousPageUrl()}}"
                            class="btn btn-default btn-sm {{$messages->onFirstPage() ? 'disabled' : ''}}"><i
                                class="fas fa-chevron-right"></i></a>
                    </div>
                    <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
            </div>
        </div>
        @else
        <div class="alert alert-light m-5" role="alert">
            <i class="fas fa-exclamation-circle mx-2"></i>
            <strong>{{__('lang.There is no Emails exist here')}}</strong>
        </div>
        @endif
    </div>
    <!-- /.card -->
</div>
<!-- /.col -->

@push('js')
<script>
    refresh()
    mark()
    del_multi()
</script>
@endpush


@endsection