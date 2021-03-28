@extends('layouts.app')

@section('title' , '| '.trans('lang.Add new Post'))

@push('css')
<link href="{{url('select2-4.1.0/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center py-5">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <ol class="breadcrumb my-3">
                <li class="breadcrumb-item"><a href="{{url('')}}">{{ trans('lang.Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{url('posts')}}">{{ trans('lang.The posts') }}</a>
                </li>
                <li class="breadcrumb-item active">{{trans('lang.Add new Post')}}</li>
            </ol>

            <form method="POST" action="{{ route('posts.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-md-4 form-group">
                        <label for="thumbnail">{{ trans('lang.Image') }}</label>
                        <input type="file" id="thumbnail" class="form-control-file
                            @error('thumbnail') is-invalid @enderror" name="thumbnail" aria-describedby="fileHelpId">
                        @error('thumbnail')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="category">
                            {{trans('lang.The Category')}}</label>
                        <select id="category" name="category"
                            class="form-control @error('category') is-invalid @enderror" required="required">
                            <option value="na" selected="">{{trans('lang.Choose One')}}:</option>
                            @foreach ($allCategories as $category)
                            <option value={{$category->id}}>{{ $category->{'title_'.app()->getLocale()} }}</option>
                            @endforeach
                        </select>
                        @error('category')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    @can('admin')
                    <div class="col-md-4 form-group">
                        <label for="status">{{ trans('lang.Status') }}</label>
                        <select id="status" class="form-control @error('status') is-invalid @enderror" name="status">
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
                    @endcan

                </div>

                <div class="form-group">
                    <label for="tags">{{ trans('lang.The tags') }}</label>
                    <select class="form-control tagsSelect2 @error('tags') is-invalid @enderror" id="tags" name="tags[]"
                        multiple="multiple">
                        @foreach ($allTags as $tag)
                        <option value="{{$tag}}"
                            {{ old('tag') !== Null ? (in_array($tag, old('tag')) ? 'selected' : '') : ''}}>
                            {{ $tag }}
                        </option>
                        @endforeach
                    </select>
                    @if($errors->first('tags'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('tags') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="title">{{ trans('lang.Post title') }}</label>
                    <input id="title" type="text" value="{{ old('title')}}"
                        class="form-control @error('title') is-invalid @enderror" name="title">
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="body">{{ trans('lang.Body') }}</label>
                    <textarea id="body" class="form-control
                    @error('body') is-invalid @enderror" name="body">{{ old('body') }}</textarea>
                    @error('body')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-danger">{{ trans('lang.Add post') }}</button>
                </div>
            </form>

        </div>
        <!-- End Blog Entries Column -->




        <!-- Sidebar Column -->
        <div class="col-md-4">


            <!-- Tags Widget -->
            @if (count($mostTags) > 0)
            <div class="card my-3">
                <h5 class="card-header">{{__('lang.The most tags used')}}</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="flexy">
                            @foreach ($mostTags as $tag)
                            <div class="badge">
                                <a href="{{url('posts?tag='.$tag->slug)}}">{{$tag->name}}</a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Categories Widget -->
            @if (count($allCategories) > 0)
            <div class="card my-3">
                <h5 class="card-header">{{__('lang.Categories')}}</h5>
                <div class="card-body">
                    <div class="row">
                        @foreach ($allCategories->chunk(1) as $chunk)
                        <div class="col-lg-6">
                            <ul class="list-unstyled mb-0">
                                @foreach ($chunk as $category)
                                <li>
                                    <a class="text-danger"
                                        href="{{url('posts?category='.$category->slug)}}">{{$category->{'title_'.app()->getLocale()} }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

        </div>
        <!-- End Sidebar Column -->

    </div>
</div>
@endsection

@push('js')
<script src="{{url('ckeditor4/ckeditor.js')}}"> </script>
<script src="{{url('select2-4.1.0/dist/js/select2.min.js')}}"></script>
<script>
    CKEDITOR.replace( 'body' ,
    {
        contentsCss : 'body{background-color: #F1AB30;}'
    }
    );

tagsSelect2();
</script>
@endpush