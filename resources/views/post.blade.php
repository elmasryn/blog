@extends('layouts.app')

@section('title', '| ' . $post->title)

@section('description', ', ' . str_limit(strip_tags($post->body), 120))
@section('keywords', ', ' . $keywords)

    @push('css')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center py-5">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <ol class="breadcrumb my-3">
                    <li class=" breadcrumb-item"><a href="{{ url('') }}">{{ trans('lang.Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('posts') }}">{{ trans('lang.The posts') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $post->title }}</li>
                </ol>

                <div class="post-alert">
                    @if ($post->getRawOriginal('status') == '0')
                        <div class="alert alert-danger m-2 text-center d-block" role="alert">
                            <strong>{{ __('lang.The post is under review and has not been published yet') }}</strong>
                        </div>
                    @endif
                </div>

                <h3>{{ $post->title }}</h3>
                <p class="lead">
                    {{ trans('lang.By') }}
                    <a href="{{ url('profile/' . $post->user_id) }}">{{ $post->user->name }}</a>

                <ul class="list-inline list-unstyled">
                    <li class="list-inline-item">
                        <span class="ml-1">
                            <i class="fas fa-list"></i>
                            <a class="text-dark" href="{{ url('posts?category=' . $post->category->slug) }}">
                                {{ $post->category->{'title_' . app()->getLocale()} }}
                            </a>
                        </span>
                    </li>
                    <li class="list-inline-item">
                        <span class="ml-1">
                            @foreach ($tags as $tagName => $tagSlug)
                                <a href="{{ url('posts?tag=' . $tagSlug) }}">
                                    <span class="badge badge-pill badge-info">{{ $tagName }}</span>
                                </a>
                            @endforeach
                        </span>
                    </li>
                </ul>

                </p>
                <hr>
                <p>{{ trans('lang.Posted on') }} {{ $post->created_at->format('F j, Y') }} {{ trans('lang.At') }}
                    {{ $post->created_at->format('g:i a') }}</p>
                <hr>

                <!-- Blog Post -->
                <div class="card mb-4 post">
                    @isset($post->thumbnail)
                        <img class="card-img-top" width="1280" height="800" src="{{ url($post->thumbnail) }}"
                            alt="{{ $post->title }}">{{-- <<<<<<<<<<<<< image --}}
                    @else
                        <img class="card-img-top" width="1280" height="800" src="{{ url('img/thumbnail/default2.jpg') }}"
                            alt="{{ $post->title }}">
                    @endisset
                    <div class="card-body">
                        <p class="card-text">{!! clean($post->body) !!}</p>
                    </div>
                </div>

                @if ($comments != null)
                    @include('comments')
                @else
                    @isset(setting()->comment_message)
                        <div class="alert alert-danger m-5 p-5 text-center" role="alert">
                            <strong>{{ setting()->comment_message }}</strong>
                        </div>
                    @endisset
                @endif


            </div>
            <!-- End Blog Entries Column -->




            <!-- Sidebar Column -->
            <div class="col-md-4">

                <!-- admin Widget -->
                @canany(['admin', 'editor', 'owner'], $post)
                    <div class="card my-3">
                        <h5 class="card-header">{{ __('lang.Welcome') . ' ' . auth()->user()->name }}</h5>
                        <div class="card-body post-widgets text-center">
                            @canany(['admin', 'editor'])
                                <a href="{{ url('posts/create') }}" class="col btn btn-secondary mb-4"><i
                                        class="fas fa-plus mr-1 my-auto"></i>{{ __('lang.Add new Post') }}</a>
                            @endcanany
                            @canany(['admin', 'ownerTime'], $post)
                                <a href="{{ url('posts/' . $post->id . '/edit') }}" class="btn btn-info m-2"><i
                                        class="fas fa-edit mr-1 my-auto"></i>{{ __('lang.Edit') }}</a>
                                @include('post_delBtn')
                            @endcanany
                            @can('admin')
                                @if ($post->getRawOriginal('status') == '1')
                                    <button type="button" class="btn btn-warning btn-block publish mt-4"
                                        postId="{{ $post->id }}"
                                        postStatus="{{ $post->getRawOriginal('status') }}">{{ trans('lang.Hide') }}</button>
                                @else
                                    <button type="button" class="btn btn-success btn-block publish mt-4"
                                        postId="{{ $post->id }}"
                                        postStatus="{{ $post->getRawOriginal('status') }}">{{ trans('lang.Publish') }}</button>
                                @endif
                            @endcan
                        </div>
                    </div>
                @endcanany

                <!-- Ads Widget -->
                @if (count($ads) > 0)
                    <div class="card my-3">
                        <h5 class="card-header">{{ __('lang.Ads') }}</h5>
                        @foreach ($ads as $link => $value)
                            <div class="card-body">
                                @if (strstr($link, 'href') or strstr($value, 'href'))
                                    {!! $link ?? $value !!}
                                @else
                                    <a href="{{ $link }}">
                                        @if ($value == null)
                                            <img src="{{ url('img/addds.png') }}" style="width:100%"
                                                alt="{{ __('lang.Ads') }}" />
                                        @else
                                            <img src="{{ url('img/' . $value) }}" style="width:100%"
                                                alt="{{ __('lang.Ads') }}" />
                                        @endif
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

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
    <script type="text/javascript">
        publishPost()
    </script>
@endpush
