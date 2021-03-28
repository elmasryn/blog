@extends('admin.master')
@if (request('commentPost'))
@section('title' , '| '.trans('lang.Comments refer to post').' '.$postTitle)
@elseif (request('commentUser'))
@section('title' , '| '.trans('lang.Comments refer to user').' '.$userName)
@else
@section('title' , '| '.__('lang.The comments'))
@endif
@push('css')
<link rel="stylesheet" href="{{url('')}}/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{url('')}}/css/buttons.dataTables.min.css">
<style>
    #comments-table td {
        vertical-align: middle;
    }
</style>
@endpush
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if (request('commentPost'))
                    <h1 class="m-0 text-dark">{{ trans('lang.Comments refer to post').' '.$postTitle}}</h1>
                    @elseif (request('commentUser'))
                    <h1 class="m-0 text-dark">{{ trans('lang.Comments refer to user').' '.$userName}}</h1>
                    @else
                    <h1 class="m-0 text-dark">{{ trans('lang.The comments') }}</h1>
                    @endif
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class=" breadcrumb-item"><a href="{{adminurl('')}}">{{ trans('lang.Home') }}</a></li>
                        @if (request('commentPost'))
                        <li class="breadcrumb-item"><a
                                href="{{adminurl('comments')}}">{{ trans('lang.The comments') }}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ trans('lang.Comments refer to post').' '.$postTitle}}
                        </li>
                        @elseif (request('commentUser'))
                        <li class="breadcrumb-item"><a
                                href="{{adminurl('comments')}}">{{ trans('lang.The comments') }}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ trans('lang.Comments refer to user').' '.$userName}}
                        </li>
                        @else
                        <li class="breadcrumb-item active">{{ trans('lang.The comments') }}</li>
                        @endif
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="container">
                    <form id="del_form" method="POST" action="{{route(adminview('comments.multidestroy'))}}">
                        @csrf
                        @method('DELETE')
                        {!! $dataTable->table(['class' => 'table table-bordered table-striped table-hover
                        w-100 text-center'],true) !!}
                        @include('admin.comments_del_multi')
                    </form>
                </div>

            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

@endsection

@push('js')
<script type="text/javascript" charset="utf8" src="{{url('')}}/js/jquery.dataTables.js"></script>
<script src="{{url('')}}/js/dataTables.buttons.min.js"></script>
<script src="{{url('')}}/vendor/datatables/buttons.server-side.js"></script>
{!! $dataTable->scripts() !!}

<script>
    multidestroy()
</script>

@endpush