@extends('admin.master')
@section('title' , '| '.__('lang.Add tag'))
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ trans('lang.Add tag') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class=" breadcrumb-item"><a href="{{adminurl('')}}/">{{ trans('lang.Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{adminurl('tags')}}/">{{ trans('lang.The tags') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('lang.Add tag') }}</li>
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

                    <form method="POST" action="{{ route(adminview('tags.store'))}}" class=" w-50">
                        @csrf

                        <div class="form-group border-bottom p-3">
                            <label for="name">{{ trans('lang.Tag name') }}</label>
                            <input id="name" type="text" value="{{ old('name')}}"
                                class="form-control @error('name') is-invalid @enderror" name="name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <button type="submit" class="btn btn-primary">{{ trans('lang.Add tag') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

@endsection