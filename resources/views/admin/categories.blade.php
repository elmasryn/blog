@extends('admin.master')
@section('title' , '| '.__('lang.The categories'))
@push('css')
<link rel="stylesheet" href="{{url('')}}/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{url('')}}/css/buttons.dataTables.min.css">
<style>
    #categories-table td {
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
                    <h1 class="m-0 text-dark">{{ trans('lang.The categories') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class=" breadcrumb-item"><a href="{{adminurl('')}}/">{{ trans('lang.Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ trans('lang.The categories') }}</li>
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
                    <form id="del_form" method="POST" action="{{route(adminview('categories.multidestroy'))}}">
                        @csrf
                        @method('DELETE')
                        {!! $dataTable->table(['class' => 'table table-bordered table-striped table-hover
                        w-100 text-center'],true) !!}
                        @include('admin.categories_del_multi')
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