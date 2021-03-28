@extends('admin.master')
@section('title' , '| '.__('lang.Edit content'))
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ trans('lang.Edit content') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class=" breadcrumb-item"><a href="{{adminurl('')}}/">{{ trans('lang.Home') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{adminurl('website_contents')}}/">{{ trans('lang.The contents') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('lang.Edit content') }}</li>
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
                    <form method="POST" action="{{ route(adminview('website_contents.update'),$website_content->id)}}"
                        class=" w-50">
                        @csrf
                        @method('PUT')
                        <div class="form-group border-bottom p-3">
                            <label for="area">{{ trans('lang.Content area') }}</label>
                            <select id="area" class="form-control @error('area') is-invalid @enderror" name="area">
                                @if (count($areas) > 0)
                                @foreach ($areas as $area => $id)
                                <option value="{{$id}}"
                                    {{ old('area' , optional($website_content)->area_id) ==  $id ? 'selected' : '' }}>
                                    {{ $area }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            @error('area')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @if ($website_content->website_content_area->area !== 'footer_content')
                        <div class="form-group border-bottom p-3">
                            <label for="value">{{ trans('lang.Content value') }}</label>
                            <input id="value" type="text"
                                value="{{ old('value' , optional($website_content)->value , '')}}"
                                class="form-control @error('value') is-invalid @enderror" name="value">
                            @error('value')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @else
                        <div class="form-group border-bottom p-3">
                            <label for="value">{{ trans('lang.Content value') }}</label>
                            <textarea id="value" class="form-control
                            @error('value') is-invalid @enderror" name="value" cols="40"
                                rows="7">{{ old('value' , optional($website_content)->value , '') }}</textarea>
                            @error('value')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @endif
                        <div class="form-group border-bottom p-3">
                            <label for="link">{{ trans('lang.Link') }}</label>
                            <input type="text" id="link" value="{{ old('link', optional($website_content)->link , '')}}"
                                class="form-control @error('link') is-invalid @enderror" name="link">
                            @error('link')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group border-bottom p-3">
                            <button type="submit" class="btn btn-primary">{{ trans('lang.Edit content') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

@endsection