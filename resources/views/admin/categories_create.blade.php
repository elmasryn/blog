@extends('admin.master')
@section('title' , '| '.__('lang.Add category'))
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ trans('lang.Add category') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class=" breadcrumb-item"><a href="{{adminurl('')}}/">{{ trans('lang.Home') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{adminurl('categories')}}/">{{ trans('lang.The categories') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('lang.Add category') }}</li>
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

                    <form method="POST" action="{{ route(adminview('categories.store'))}}" class=" w-50">
                        @csrf
                        <div class="form-group border-bottom p-3">
                            <label for="title_en">{{ trans('lang.Title name by English') }}</label>
                            <input id="title_en" type="text" value="{{ old('title_en')}}"
                                class="form-control @error('title_en') is-invalid @enderror" name="title_en">
                            @error('title_en')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group border-bottom p-3">
                            <label for="title_ar">{{ trans('lang.Title name by Arabic') }}</label>
                            <input type="text" id="title_ar" value="{{ old('title_ar')}}"
                                class="form-control @error('title_ar') is-invalid @enderror" name="title_ar">
                            @error('title_ar')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group border-bottom p-3">
                            <label for="desc_en">{{ trans('lang.Desc name by English') }}</label>
                            <textarea id="desc_en" class="form-control
                            @error('desc_en') is-invalid @enderror" name="desc_en" cols="40"
                                rows="7">{{ old('desc_en') }}</textarea>
                            @error('desc_en')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group border-bottom p-3">
                            <label for="desc_ar">{{ trans('lang.Desc name by Arabic') }}</label>
                            <textarea id="desc_ar" class="form-control @error('desc_ar')
                            is-invalid @enderror" name="desc_ar" cols="40" rows="7">{{ old('desc_ar') }}</textarea>
                            @error('desc_ar')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group border-bottom p-3">
                            <label for="status">{{ trans('lang.Status') }}</label>
                            <select id="status" class="form-control @error('status') is-invalid @enderror"
                                name="status">
                                <option value="1" {{ old('status' , '1') == '1' ? 'selected' : '' }}>
                                    {{ trans('lang.Published') }}</option>
                                <option value="0" {{ old('status' , '1') == '0' ? 'selected' : '' }}>
                                    {{ trans('lang.Not Published') }}</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group border-bottom p-3">
                            <button type="submit" class="btn btn-primary">{{ trans('lang.Add category') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

@endsection