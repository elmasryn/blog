@extends('layouts.app')
@push('css')
<link href="{{ url('css/profile.css') }}" rel="stylesheet">
@endpush

@section('title' , '| '.__('lang.Profile'))

@section('content')

<div class="container emp-profile">
    <div class="row">
        <div class="col-md-4">
            <div class="file-upload">
                @if(empty($user->profile->avatar))
                <img src="{{url('img/avatar/default.png')}}" style="width:183px;height:183px" />
                @else
                <img src="{{url($user->profile->avatar)}}" style="width:183px;height:183px" />
                @endif
                {{-- 275*183 --}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="profile-head mt-2">
                <h5>
                    {{$user->name}}
                </h5>
                <h6>
                    {{$roleName}}
                </h6>
                <p class="proile-rating">{{__('lang.Favorite language')}} :
                    <span class=" text-danger">
                        {{isset($user->profile->lang) ? ($user->profile->lang =='en'?'English':'العربية') : __('lang.None')}}
                    </span>
                </p>
            </div>
        </div>
        <div class="col-md-2">
            @canany(['admin', 'owner'], $user->profile)
            <a href="{{route('profile.edit',$user->profile->user_id)}}"
                class="btn btn-secondary text-light">{{__('lang.Edit profile')}}</a>
            @endcanany
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 mt-5">
            <div class="profile-work text-danger">
                <p>{{__('lang.About me')}}</p>
                {{optional($user->profile)->about}}
            </div>
        </div>
        <div class="col-md-7">
            <h4>
                {{__('lang.Info')}}
            </h4>
            <hr>
            <div class="row">
                <div class="col-md-5">
                    <label>{{__('lang.User Id')}}</label>
                </div>
                <div class="col-md-7 text-danger">
                    <p>{{$user->id}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <label>{{__('lang.Name')}}</label>
                </div>
                <div class="col-md-7 text-danger">
                    <p>{{$user->name}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <label>{{__('lang.Email')}}</label>
                </div>
                <div class="col-md-7 text-danger">
                    <p>{{$user->email}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <label>{{__('lang.Created_at')}}</label>
                </div>
                <div class="col-md-7 text-danger">
                    <p>{{$user->created_at}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <label>{{__('lang.Last update')}}</label>
                </div>
                <div class="col-md-7 text-danger">
                    <p>{{$user->updated_at}}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection