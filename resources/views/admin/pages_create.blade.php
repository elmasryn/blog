@extends('admin.master')
@section('title' , '| '.__('lang.Add page'))
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ trans('lang.Add page') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class=" breadcrumb-item"><a href="{{adminurl('')}}/">{{ trans('lang.Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{adminurl('pages')}}/">{{ trans('lang.The pages') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('lang.Add page') }}</li>
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

                    <form method="POST" action="{{ route(adminview('pages.store'))}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 form-group border-bottom p-3">
                                <label for="title_en">{{ trans('lang.Title page name by English') }}</label>
                                <input id="title_en" type="text" value="{{ old('title_en')}}"
                                    class="form-control @error('title_en') is-invalid @enderror" name="title_en">
                                @error('title_en')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group border-bottom p-3">
                                <label for="title_ar">{{ trans('lang.Title page name by Arabic') }}</label>
                                <input type="text" id="title_ar" value="{{ old('title_ar')}}"
                                    class="form-control @error('title_ar') is-invalid @enderror" name="title_ar">
                                @error('title_ar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-md-4 form-group border-bottom p-3">
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
                        </div>


                        <div class="form-group border-bottom p-3">
                            <label for="body">{{ trans('lang.Body') }}</label>
                            <textarea id="body" class="form-control
                            @error('body') is-invalid @enderror" name="body">{{ old('body') }}</textarea>
                            @error('body')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <button type="submit" class="btn btn-primary">{{ trans('lang.Add page') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

@endsection

@push('js')
<script src="{{url('ckeditor4/ckeditor.js')}}"> </script>
<script>
    CKEDITOR.replace( 'body' );
</script>

@endpush