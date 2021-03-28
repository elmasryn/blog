@extends('admin.master')
@section('title' , '| '.__('lang.Add user'))
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ trans('lang.Add user') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class=" breadcrumb-item"><a href="{{adminurl('')}}/">{{ trans('lang.Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{adminurl('users')}}/">{{ trans('lang.The users') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('lang.Add user') }}</li>
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

                    <form method="POST" action="{{ route(adminview('users.store'))}}" enctype="multipart/form-data"
                        class=" w-50">
                        @csrf

                        <div class="file-upload">
                            <img src="{{url('img/avatar/default.png')}}" />
                            <div class="file btn btn-lg btn-primary">
                                {{__('lang.Change photo')}}
                                <input type="file" name="image" />
                            </div>
                        </div>
                        @if ($errors->first('image'))
                        <div class="alert alert-danger">
                            {{ $errors->first('image') }}
                        </div>
                        @endif

                        <div class="form-group border-bottom p-3">
                            <label for="name">{{ trans('lang.Name') }}</label>
                            <input id="name" type="text" value="{{ old('name')}}"
                                class="form-control @error('name') is-invalid @enderror" name="name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <label for="email">{{ trans('lang.Email') }}</label>
                            <input type="text" id="email" value="{{ old('email')}}"
                                class="form-control @error('email') is-invalid @enderror" name="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <label for="password">{{ trans('lang.Password') }}</label>
                            <input type="password" id="password" placeholder="{{ trans('lang.Password') }}"
                                class="form-control @error('password') is-invalid @enderror" name="password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <label for="about">{{__('lang.About user')}}</label>
                            <textarea id="about" class="form-control
                                @error('about') is-invalid @enderror" name="about" cols="40"
                                rows="7">{{ old('about') }}</textarea>
                            @error('about')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <label for="fav_lang">{{ trans('lang.Favorite language') }}</label>
                            <select id="fav_lang" name="fav_lang"
                                class="form-control @error('fav_lang') is-invalid @enderror" name="language">
                                @foreach (locales() as $key => $value)
                                <option value="{{$key}}"
                                    {{ old('fav_lang', optional(setting())->default_lang , app()->getLocale()) == $key ? 'selected' : '' }}>
                                    {{$value}}</option>
                                @endforeach
                            </select>
                            @error('fav_lang')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <label for="role">{{ trans('lang.Role') }}</label>
                            <select multiple="" id="role" name="role[]"
                                class="form-control @error('role') is-invalid @enderror" name="language">
                                @foreach ($roles as $role_id => $role_name)
                                <option value="{{$role_id}}"
                                    {{ old('role') !== Null ? (in_array($role_id, old('role')) ? 'selected' : '') : ($role_name == 'User' ? 'selected' : '')}}>
                                    {{$role_name}}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <button type="submit" class="btn btn-primary">{{ trans('lang.Add user') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

@endsection