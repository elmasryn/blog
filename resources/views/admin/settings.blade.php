@extends('admin.master')
@section('title' , '| '.__('lang.Settings'))
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ trans('lang.Settings') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class=" breadcrumb-item"><a href="{{adminurl('')}}/">{{ trans('lang.Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ trans('lang.Settings') }}</li>
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
                    <form method="POST" action="{{ route(adminview('settings.update'))}}" enctype="multipart/form-data"
                        class=" w-50">
                        @csrf

                        <div class="form-group border-bottom p-3">
                            <label for="website_en">{{ trans('lang.Website name by English') }}</label>
                            <input id="website_en" type="text"
                                value="{{ old('website_en' , optional(setting())->website_en , '')}}"
                                class="form-control @error('website_en') is-invalid @enderror" name="website_en">
                            @error('website_en')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <label for="website_ar">{{ trans('lang.Website name by Arabic') }}</label>
                            <input type="text" id="website_ar"
                                value="{{ old('website_ar', optional(setting())->website_ar , '')}}"
                                class="form-control @error('website_ar') is-invalid @enderror" name="website_ar">
                            @error('website_ar')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <label for="default_lang">{{ trans('lang.Default language') }}</label>
                            <select id="default_lang" name="default_lang"
                                class="form-control @error('default_lang') is-invalid @enderror">
                                @foreach (locales() as $key => $value)
                                <option value="{{$key}}"
                                    {{ old('default_lang', optional(setting())->default_lang , app()->getLocale()) == $key ? 'selected' : '' }}>
                                    {{$value}}</option>
                                @endforeach
                            </select>
                            @error('default_lang')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <label for="email">{{ trans('lang.Email') }}</label>
                            <input type="email" id="email" value="{{ old ('email' , optional(setting())->email , '')}}"
                                class="form-control
                                @error('email') is-invalid @enderror" name="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <label for="description">{{ trans('lang.Description') }}</label>
                            <textarea id="description" class="form-control
                                @error('description') is-invalid @enderror" name="description" cols="40"
                                rows="7">{{ old('description' , optional(setting())->description , '') }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <label for="keywords">{{ trans('lang.Keywords') }}</label>
                            <textarea id="keywords" class="form-control @error('keywords')
                                is-invalid @enderror" name="keywords" cols="40"
                                rows="7">{{ old('keywords' , optional(setting())->keywords , '') }}</textarea>
                            @error('keywords')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <label for="icon">{{ trans('lang.Website icon') }}</label>
                            <input type="file" id="icon" class="form-control-file
                                @error('icon') is-invalid @enderror" name="icon" aria-describedby="fileHelpId">
                            @error('icon')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            @if(!empty(setting()->icon))
                            <img src="{{url(setting()->icon)}}" style="width:40px;height:40px;margin-top:10px" />
                            @endif
                        </div>

                        <div class="form-group border-bottom p-3">
                            <label for="post_publish_status">{{ trans('lang.Post directly published') }}</label>
                            <select id="post_publish_status"
                                class="form-control post_publish_status @error('post_publish_status') is-invalid @enderror"
                                name="post_publish_status">
                                <option value="1"
                                    {{ old('post_publish_status' , optional(setting())->post_publish_status , '1') == '1' ? 'selected' : '' }}>
                                    {{ trans('lang.Enabled') }}</option>
                                <option value="0"
                                    {{ old('post_publish_status' , optional(setting())->post_publish_status , '1') == '0' ? 'selected' : '' }}>
                                    {{ trans('lang.Disabled') }}</option>
                            </select>
                            @error('post_publish_status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <label for="comment_publish_status">{{ trans('lang.Comment directly published') }}</label>
                            <select id="comment_publish_status"
                                class="form-control comment_publish_status @error('comment_publish_status') is-invalid @enderror"
                                name="comment_publish_status">
                                <option value="1"
                                    {{ old('comment_publish_status' , optional(setting())->comment_publish_status , '1') == '1' ? 'selected' : '' }}>
                                    {{ trans('lang.Enabled') }}</option>
                                <option value="0"
                                    {{ old('comment_publish_status' , optional(setting())->comment_publish_status , '1') == '0' ? 'selected' : '' }}>
                                    {{ trans('lang.Disabled') }}</option>
                            </select>
                            @error('comment_publish_status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <label for="comment_status">{{ trans('lang.Comment status') }}</label>
                            <select id="comment_status"
                                class="form-control comment_status @error('comment_status') is-invalid @enderror"
                                name="comment_status">
                                <option value="1"
                                    {{ old('comment_status' , optional(setting())->comment_status , '1') == '1' ? 'selected' : '' }}>
                                    {{ trans('lang.Enabled') }}</option>
                                <option value="0"
                                    {{ old('comment_status' , optional(setting())->comment_status , '1') == '0' ? 'selected' : '' }}>
                                    {{ trans('lang.Disabled') }}</option>
                            </select>
                            @error('comment_status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div
                            class="form-group border-bottom p-3 comment_message {{ old('comment_status' , optional(setting())->comment_status , '1') == '1' ? 'd-none' : '' }}">
                            <label for="comment_message">{{ trans('lang.Message for closed comments') }}</label>
                            <textarea id="comment_message"
                                class="form-control @error('comment_message') is-invalid @enderror"
                                name="comment_message" cols="40"
                                rows="7">{{ old('comment_message' , optional(setting())->comment_message , '') }}</textarea>
                            @error('comment_message')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <label for="website_status">{{ trans('lang.Website status') }}</label>
                            <select id="website_status"
                                class="form-control website_status @error('website_status') is-invalid @enderror"
                                name="website_status">
                                <option value="1"
                                    {{ old('website_status' , optional(setting())->website_status , '1') == '1' ? 'selected' : '' }}
                                    selected>
                                    {{ trans('lang.Opened') }}</option>
                                <option value="0"
                                    {{ old('website_status' , optional(setting())->website_status , '1') == '0' ? 'selected' : '' }}>
                                    {{ trans('lang.Closed') }}</option>
                            </select>
                            @error('website_status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div
                            class="form-group border-bottom p-3 website_message {{ old('website_status' , optional(setting())->website_status , '1') == '1' ? 'd-none' : '' }}">
                            <label for="website_message">
                                {{ trans('lang.Message for closed Website') }}</label>
                            <textarea id="website_message"
                                class="form-control @error('website_message') is-invalid @enderror"
                                name="website_message" cols="40"
                                rows="7">{{ old('website_message' , optional(setting())->website_message , '') }}</textarea>
                            @error('website_message')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <button type="submit" class="btn btn-primary">{{ trans('lang.Finish') }}</button>
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
<script type="text/javascript">
    show_comment_message()
    show_website_message()
</script>
@endpush