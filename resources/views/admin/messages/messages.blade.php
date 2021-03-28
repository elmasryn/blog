@extends('admin.master')
@section('title' , '| '.__('lang.Mailbox'))
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ trans('lang.Mailbox') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class=" breadcrumb-item">
                            <a href="{{adminurl('')}}">{{ trans('lang.Home') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{adminurl('messages')}}">{{ trans('lang.Mailbox') }}</a>
                        </li>

                        @yield('breadcrumb')
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">

                @include('admin.messages.block_folders')

                @include('admin.messages.block_departments')

                @include('admin.messages.block_add_category')

            </div>
            <!-- /.col -->
            @yield('mailContent')
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

@endsection


@push('js')
<script type="text/javascript">
    multi_check()
</script>


@endpush