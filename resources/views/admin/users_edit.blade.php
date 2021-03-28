@extends('admin.master')
@section('title' , '| '.__('lang.Edit user'))
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ trans('lang.Edit user') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class=" breadcrumb-item"><a href="{{adminurl('')}}/">{{ trans('lang.Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{adminurl('users')}}/">{{ trans('lang.The users') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('lang.Edit user') }}</li>
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
                    <form method="POST" action="{{ route(adminview('users.update'),$user->id)}}"
                        enctype="multipart/form-data" class=" w-50">
                        @csrf
                        @method('PUT')

                        <div class="file-upload">
                            @if(empty($user->profile->avatar))
                            <img src="{{url('img/avatar/default.png')}}" />
                            <div class="file btn btn-lg btn-default">
                                {{__('lang.Change photo')}}
                                <input type="file" name="image" />
                            </div>
                            @else
                            <img src="{{url($user->profile->avatar)}}" />
                            <div class="file btn btn-lg btn-primary">
                                {{__('lang.Change photo')}}
                                <input type="file" name="image" />
                            </div>
                            @endif
                        </div>
                        @if ($errors->first('image'))
                        <div class="alert alert-danger">
                            {{ $errors->first('image') }}
                        </div>
                        @endif

                        <div class="form-group border-bottom p-3">
                            <label for="name">{{ trans('lang.Name') }}</label>
                            <input id="name" type="text" value="{{ old('name' , optional($user)->name , '')}}"
                                class="form-control @error('name') is-invalid @enderror" name="name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group border-bottom p-3">
                            <label for="email">{{ trans('lang.Email') }}</label>
                            <input type="text" id="email" value="{{ old('email', optional($user)->email , '')}}"
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
                                rows="7">{{ old('about' , optional($user->profile)->about , '') }}</textarea>
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
                                @empty($user->profile->lang)
                                <option value="{{Null}}" selected>{{ trans('lang.Choose the favorite language') }}
                                </option>
                                @endempty
                                @foreach (locales() as $key => $value)
                                <option value="{{$key}}"
                                    {{ old('fav_lang', optional($user->profile)->lang) == $key ? 'selected' : '' }}>
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
                                    {{ in_array($role_id, old('role') ?? $user->roles->pluck('id')->toArray()) ? 'selected' : ''}}>
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
                            <button type="submit" class="btn btn-primary">{{ trans('lang.Edit user') }}</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

@endsection