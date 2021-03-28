@extends('admin.master')
@if (request('postTag'))
@section('title' , '| '.trans('lang.Posts refer to tag').' '.$tagName)
@elseif (request('postCategory'))
@section('title' , '| '.trans('lang.Posts refer to category').' '.$categoryTitle)
@elseif (request('postUser'))
@section('title' , '| '.trans('lang.Posts refer to user').' '.$userName)
@else
@section('title' , '| '.__('lang.The posts'))
@endif
@push('css')
<link rel="stylesheet" href="{{url('')}}/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{url('')}}/css/buttons.dataTables.min.css">
<style>
    #posts-table td {
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
                    @if (request('postTag'))
                    <h1 class="m-0 text-dark">{{ trans('lang.Posts refer to tag').' '.$tagName}}</h1>
                    @elseif (request('postCategory'))
                    <h1 class="m-0 text-dark">{{ trans('lang.Posts refer to category').' '.$categoryTitle}}</h1>
                    @elseif (request('postUser'))
                    <h1 class="m-0 text-dark">{{ trans('lang.Posts refer to user').' '.$userName}}</h1>
                    @else
                    <h1 class="m-0 text-dark">{{ trans('lang.The posts') }}</h1>
                    @endif
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class=" breadcrumb-item"><a href="{{adminurl('')}}">{{ trans('lang.Home') }}</a></li>
                        @if (request('postTag'))
                        <li class="breadcrumb-item"><a href="{{adminurl('posts')}}">{{ trans('lang.The posts') }}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ trans('lang.Posts refer to tag').' '.$tagName}}
                        </li>
                        @elseif (request('postCategory'))
                        <li class="breadcrumb-item"><a href="{{adminurl('posts')}}">{{ trans('lang.The posts') }}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ trans('lang.Posts refer to category').' '.$categoryTitle}}
                        </li>
                        @elseif (request('postUser'))
                        <li class="breadcrumb-item"><a href="{{adminurl('posts')}}">{{ trans('lang.The posts') }}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ trans('lang.Posts refer to user').' '.$userName}}
                        </li>
                        @else
                        <li class="breadcrumb-item active">{{ trans('lang.The posts') }}</li>
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
                    <form id="del_form" method="POST" action="{{route(adminview('posts.multidestroy'))}}">
                        @csrf
                        @method('DELETE')
                        {!! $dataTable->table(['class' => 'table table-bordered table-striped table-hover
                        w-100 text-center'],true) !!}
                        @include('admin.posts_del_multi')
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