@extends('layouts.app')

@section('title', '| ' . trans('lang.Edit Post'))

    @push('css')
        <link href="{{ url('select2-4.1.0/dist/css/select2.min.css') }}" rel="stylesheet" />
    @endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center py-5">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <ol class="breadcrumb my-3">
                    <li class="breadcrumb-item"><a href="{{ url('') }}">{{ trans('lang.Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('posts') }}">{{ trans('lang.The posts') }}</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ url('posts/' . $post->slug) }}">{{ $post->title }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ trans('lang.Edit Post') }}</li>
                </ol>

                <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">

                        <div class="col-md-4">
                            <div class="file-upload">
                                @if (empty($post->thumbnail))
                                    <img src="{{ url('img/thumbnail/default2.jpg') }}" />
                                    <div class="file btn btn-lg btn-default align-top text-white">
                                        {{ __('lang.Change photo') }}
                                        <input type="file" name="thumbnail" />
                                    </div>
                                @else
                                    <img src="{{ url($post->thumbnail) }}" />
                                    <div class="file btn btn-lg btn-primary align-top text-white">
                                        {{ __('lang.Change photo') }}
                                        <input type="file" name="thumbnail" />
                                    </div>
                                @endif
                            </div>
                            @if ($errors->first('thumbnail'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('thumbnail') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="category">
                                {{ trans('lang.The Category') }}</label>
                            <select id="category" name="category"
                                class="form-control @error('category') is-invalid @enderror" required="required">
                                @foreach ($wholeCategories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category', optional($post)->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->{'title_' . app()->getLocale()} }}</option>
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
                                    <option value="1"
                                        {{ old('status', optional($post)->getRawOriginal('status'), '1') == '1' ? 'selected=' : '' }}>
                                        {{ trans('lang.Published') }}</option>
                                    <option value="0"
                                        {{ old('status', optional($post)->getRawOriginal('status'), '1') == '0' ? 'selected=' : '' }}>
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
                            @foreach ($allTags as $tagName => $tagId)
                                <option value="{{ $tagName }}"
                                    {{ in_array($tagName, old('tag') ?? $post->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $tagId }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->first('tags'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('tags') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="title">{{ trans('lang.Post title') }}</label>
                        <input id="title" type="text" value="{{ old('title', optional($post)->title , '') }}"
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
                        @error('body') is-invalid @enderror" name="body">{!! old('body' , clean(optional($post)->body) , '') !!}</textarea>
                        @error('body')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-danger">{{ trans('lang.Edit post') }}</button>
                    </div>
                </form>

            </div>
            <!-- End Blog Entries Column -->




            <!-- Sidebar Column -->
            <div class="col-md-4">

                <!-- Posts Widget -->
                @if (count($relatedPosts) > 0)
                    <div class="card my-3">
                        <h5 class="card-header">{{ __('lang.Related posts') }}</h5>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @foreach ($relatedPosts as $relatedPost)
                                    <li class="list-group-item list-relatedPosts">
                                        <a class="text-dark" href="{{ url('posts/' . $relatedPost->slug) }}">
                                            {{ str_limit($relatedPost->title, 100) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Tags Widget -->
                @if (count($relatedTags) > 0)
                    <div class="card my-3">
                        <h5 class="card-header">{{ __('lang.Related tags') }}</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="flexy">
                                    @foreach ($relatedTags as $tagSlug => $tagName)
                                        <div class="badge">
                                            <a href="{{ url('posts?tag=' . $tagSlug) }}">{{ $tagName }}</a>
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
                        <h5 class="card-header">{{ __('lang.Categories') }}</h5>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($allCategories->chunk(1) as $chunk)
                                    <div class="col-lg-6">
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($chunk as $category)
                                                <li>
                                                    <a class="text-danger"
                                                        href="{{ url('posts?category=' . $category->slug) }}">{{ $category->{'title_' . app()->getLocale()} }}</a>
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
    <script src="{{ url('ckeditor4/ckeditor.js') }}"> </script>
    <script src="{{ url('select2-4.1.0/dist/js/select2.min.js') }}"></script>
    <script>
        CKEDITOR.replace('body', {
            contentsCss: 'body{background-color: #F1AB30;}'
        });

        tagsSelect2();

    </script>
@endpush
