@extends('layouts.app')
@push('css')
<link href="/css/profile.css" rel="stylesheet">
@endpush

@section('title' , '| '.__('lang.Edit profile'))

@section('content')

<div class="container emp-profile">
    <form method="post" action="{{route('profile.update',$user->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-4">
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
            </div>
            <div class="col-md-6">
                <div class="profile-head">
                    <h5>
                        <a href="{{route('profile.show',$user->id)}}"> {{$user->name}} </a>
                    </h5>
                    <h6>
                        {{$roleName}}
                    </h6>
                </div>
            </div>
            <div class="col-md-2">
                <input type="submit" class="profile-edit-btn" name="btnAddMore" value="{{__('lang.Edit')}}" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="profile-work">
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-4 align-self-center">
                        <label>{{__('lang.User Id')}}</label>
                    </div>
                    <div class="col-md-8">
                        <p>{{$user->id}}</p>
                    </div>
                </div>
                <div class=" row">
                    <div class="col-md-4 align-self-center">
                        <label for="name">{{__('lang.Name')}}</label>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input id="name" type="text" value="{{ old('name' , optional($user)->name , '')}}"
                                class="form-control @error('name') is-invalid @enderror" name="name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 align-self-center">
                        <label for="email">{{ trans('lang.Email') }}</label>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="email" id="email" value="{{ old ('email' , optional($user)->email , '')}}"
                                class="form-control
                                @error('email') is-invalid @enderror" name="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 align-self-center">
                        <label for="fav_lang">{{ trans('lang.Favorite language') }}</label>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <select id="fav_lang" name="fav_lang"
                                class="form-control @error('fav_lang') is-invalid @enderror">
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
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 align-self-center">
                        <label for="about">{{__('lang.About me')}}</label>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <textarea id="about" class="form-control
                                @error('about') is-invalid @enderror" name="about" cols="40"
                                rows="7">{{ old('about' , optional($user->profile)->about , '') }}</textarea>
                            @error('about')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-7 offset-md-7">
                        <input type="submit" class="profile-edit-btn" name="btnAddMore" value="{{__('lang.Edit')}}" />
                    </div>
                </div>
            </div>
        </div>
    </form>
    <hr>
    <form method="post" action="{{route('profile.password',$user->id)}}">
        @csrf
        @method('PUT')
        <div class="col-md-8 offset-md-4 mt-5">
            <div class="row">
                <div class="col-md-4 align-self-center">
                    <label for="password">{{ trans('lang.Password') }}</label>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="password" id="password" placeholder="{{ trans('lang.Password') }}" class="form-control
                    @error('password') is-invalid @enderror" name="password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 align-self-center">
                    <label for="Password confirmation">{{ trans('lang.Password confirmation') }}</label>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="password" id="Password confirmation"
                            placeholder="{{ trans('lang.Password confirmation') }}" class="form-control"
                            name="password_confirmation">
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-secondary btn-sm">{{ trans('lang.Change password') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection