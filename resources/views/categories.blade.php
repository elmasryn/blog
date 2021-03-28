@extends('layouts.app')

@section('title' , '| '.__('lang.Categories'))

@section('keywords' ,', '.$keywords)

@section('content')
<div class="container">
    <div class="row justify-content-center py-5">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <nav class="breadcrumb my-3">
                <a class="breadcrumb-item" href="{{url('')}}">{{ trans('lang.Home') }}</a>
                <span class="breadcrumb-item active">{{ trans('lang.The categories') }}</span>
            </nav>

            <div class="row">
                @if (count($categories) > 0)
                @foreach ($categories as $category)
                <div class="col-md-6">
                    <h3>{{ $category->{'title_'.app()->getLocale()} }}</h3>
                    <p class="cat-p">{{str_limit($category->{'desc_'.app()->getLocale()},120)}}</p>
                    <p>
                        <a class="btn btn-secondary" href="{{url('posts?category='.$category->slug)}}">
                            {{__('lang.More info')}} >>
                        </a>
                    </p>
                    @if ($loop->remaining > 1)
                    <hr class="my-4">
                    @endif
                </div>
                @endforeach
                <div class="mt-4 mx-auto">{{$categories->links()}}</div>
                @endif
            </div>

        </div>
        <!-- End Blog Entries Column -->




        <!-- Sidebar Column -->
        <div class="col-md-4">

            <!-- admin Widget -->
            @canany(['admin', 'editor'])
            <div class="card my-3">
                <h5 class="card-header">{{ __('lang.Welcome').' '.auth()->user()->name }}</h5>
                <div class="card-body post-widgets text-center">
                    <a href="{{url('posts/create')}}" class="col btn btn-secondary mb-4"><i
                            class="fas fa-plus mr-1 my-auto"></i>{{ __('lang.Add new Post') }}</a>
                </div>
            </div>
            @endcanany

            <!-- Ads Widget -->
            @if (count($ads) > 0)
            <div class="card my-3">
                <h5 class="card-header">{{__('lang.Ads')}}</h5>
                @foreach ($ads as $link => $value)
                <div class="card-body">
                    @if (strstr($link,'href') or strstr($value,'href') )
                    {!! $link ?? $value !!}
                    @else
                    <a href="{{$link}}">
                        @if ($value == Null)
                        <img src="{{url('img/addds.png')}}" style="width:100%" alt="{{__('lang.Ads')}}" />
                        @else
                        <img src="{{url('img/'.$value)}}" style="width:100%" alt="{{__('lang.Ads')}}" />
                        @endif
                    </a>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

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