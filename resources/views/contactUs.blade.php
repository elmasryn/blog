@extends('layouts.app')
@push('css')
<link href="{{ url('css/contactUs.css') }}" rel="stylesheet">
@endpush

@section('title' , '| '.__('lang.Contact us'))

@section('content')
<div class="jumbotron jumbotron-sm">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <h1 class="h1">
                    {{trans('lang.Contact us')}} <small>{{trans('lang.Feel free to contact us')}}</small></h1>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="card card-sm p-3">
                <form method="POST" action="{{ route('contactUs.store')}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">
                                    {{trans('lang.Name')}}</label>
                                <input type="text" value="{{ old('name' , optional(Auth::user())->name , '')}}"
                                    class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                                    placeholder="{{trans('lang.Enter name')}}" required="required" />
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">
                                    {{trans('lang.E-Mail Address')}}</label>
                                <div class="input-group">
                                    </span>
                                    <input type="email" value="{{ old('email' , optional(Auth::user())->email , '')}}"
                                        class=" form-control
                                        @error('email') is-invalid @enderror" name="email" id="email"
                                        placeholder="{{trans('lang.Enter email')}}" required="required" />
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="subject">
                                    {{trans('lang.Subject')}}</label>
                                <select id="subject" name="subject"
                                    class="form-control @error('subject') is-invalid @enderror" required="required">
                                    <option value="na" selected="">{{trans('lang.Choose One')}}:</option>
                                    @foreach (App\Message_title::all() as $key => $value)
                                    <option value={{$key+1}}>{{ $value->{'title_'.app()->getLocale()} }}</option>
                                    @endforeach
                                </select>
                                @error('subject')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="message">
                                    {{trans('lang.Message')}}</label>
                                <textarea name="message" id="message"
                                    class="form-control @error('message') is-invalid @enderror" rows="9" cols="25"
                                    required="required"
                                    placeholder="{{trans('lang.Message text')}}">{{ old('message' , '')}}</textarea>
                                @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-info float-right" id="btnContactUs">
                                {{trans('lang.Send Message')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection