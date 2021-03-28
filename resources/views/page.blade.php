@extends('layouts.app')

@section('title' , '| '.$page->{'title_'.app()->getLocale()} )

@section('description' , ', '.str_limit(strip_tags($page->body),120) )
@section('keywords' ,', '.$keywords)

@section('content')
<div class="container">
    <div class="row justify-content-center py-5">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <ol class="breadcrumb my-3">
                <li class=" breadcrumb-item"><a href="{{url('')}}">{{ trans('lang.Home') }}</a></li>
                <li class="breadcrumb-item active">{{$page->{'title_'.app()->getLocale()} }}</li>
            </ol>


            <!-- Blog Page -->
            @isset($page->body)
            <div class="card mb-4 page">
                <div class="card-body">
                    <p class="card-text">{!! clean($page->body) !!}</p>
                </div>
            </div>
            @endisset


        </div>
        <!-- End Blog Entries Column -->


        <!-- Sidebar Column -->
        <div class="col-md-4">


            <!-- Ads Widget -->
            @if (count($ads) > 0)
            <div class="card my-3">
                <h5 class="card-header">{{__('lang.Ads')}}</h5>
                @foreach ($ads as $link => $value)
                <div class="card-body">
                    @if (strstr($link,'href') or strstr($value,'href') )
                    {!! clean($link) ?? clean($value) !!}
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

            <!-- Pages Widget -->
            @if (count($allPages) > 0)
            <div class="card my-3">
                <h5 class="card-header">{{__('lang.The pages')}}</h5>
                <div class="card-body">
                    <div class="row">
                        @foreach ($allPages->chunk(1) as $chunk)
                        <div class="col-lg-6">
                            <ul class="list-unstyled mb-0">
                                @foreach ($chunk as $page)
                                <li>
                                    <a class="text-danger"
                                        href="{{url('page/'.$page->slug)}}">{{$page->{'title_'.app()->getLocale()} }}</a>
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