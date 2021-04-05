@extends('layouts.app')
@if (request('category'))
@section('title' , '| '.$category->{'title_'.app()->getLocale()})
@section('description' , ', '.$category->{'desc_'.app()->getLocale()} )
@elseif (request('tag'))
@section('title' , '| '.$tag->name)
@else
@section('title' , '| '.__('lang.All posts'))
@endif
@section('keywords' ,', '.$keywords)

@section('content')
<div class="container">
    <div class="row justify-content-center py-5">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <ol class="breadcrumb my-3">
                <li class=" breadcrumb-item"><a href="{{url('')}}">{{ trans('lang.Home') }}</a></li>
                @if (request('category'))
                <li class=" breadcrumb-item"><a href="{{url('posts')}}">{{ trans('lang.All posts') }}</a></li>
                <li class="breadcrumb-item active">{{ $category->{'title_'.app()->getLocale()} }}</li>
                @elseif (request('tag'))
                <li class=" breadcrumb-item"><a href="{{url('posts')}}">{{ trans('lang.All posts') }}</a></li>
                <li class="breadcrumb-item active">{{ $tag->name }}</li>
                @else
                <li class="breadcrumb-item active">{{ trans('lang.All posts') }}</li>
                @endif
            </ol>

            @if(count($posts) > 0)
            @foreach ($posts as $post)
            <ul class="list-unstyled">
                <li class="media"> {{--<<<<<<<<<<<<< image --}}
                    <a class="text-dark" href="{{url('posts/'.$post->slug)}}">
                        @isset($post->thumbnail)
                        <img src="{{asset($post->thumbnail)}}" class="mr-3" style="width:140px;height:140px;"
                            alt="{{$post->title}}" />
                        @else
                        <img src="{{asset('img/thumbnail/default2.jpg')}}" class="mr-3"
                            style="width:140px;height:140px;" alt="{{$post->title}}" />
                        @endisset
                    </a>
                    <div class="media-body">
                        <h4 class="mt-0 mb-1">
                            <a class="text-dark" href="{{url('posts/'.$post->slug)}}">{{$post->title}}</a>
                        </h4>
                        <h6 class="mb-0"><span><i class="fas fa-user"></i></span> {{trans('lang.By')}}
                            <a class="text-secondary" href="{{url('profile/'.$post->user_id)}}">
                                {{$post->user->name}}
                            </a>
                        </h6>
                        @foreach ($post->tags as $tag)
                        <span class="badge badge-pill badge-primary">{{$tag->name}}</span>
                        @endforeach
                        <br>
                        <p>{{str_limit(strip_tags($post->body),250)}}</p>
                        <ul class="list-inline list-unstyled">
                            <li class="list-inline-item">
                                <span>
                                    <i class="far fa-clock"></i>
                                    {{trans('lang.Posted on')}}
                                    {{ $post->created_at->format('Y-m-d') }} {{trans('lang.At')}}
                                    {{ $post->created_at->format('H:i A') }}
                                </span>
                            </li> |
                            <li class="list-inline-item">
                                <span class="ml-1">
                                    <i class="fas fa-comment"></i>
                                    <span class="text-danger font-weight-bold">{{$post->comments_count}} </span>
                                    {{trans_choice('lang.Comments' , $post->comments_count)}}
                                </span>
                            </li>
                            @if (!request('category'))
                            |
                            <li class="list-inline-item">
                                <span class="ml-1">
                                    <i class="fas fa-list"></i>
                                    {{$post->category->{'title_'.app()->getLocale()} }}
                                </span>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
            </ul>
            <p class="text-right">
                <a class="btn btn-sm btn-secondary" href="{{url('posts/'.$post->slug)}}">
                    {{__('lang.Full Post')}} >>
                </a>
            </p>
            @if ($loop->remaining > 0)
            <hr class="my-4">
            @endif
            @endforeach
            @else
            <div class="alert alert-danger" role="alert">
                <strong>{{trans('lang.No posts in current time')}}</strong>
            </div>
            @endif

            <div class="d-flex justify-content-center">{{$posts->withQueryString()->links()}}</div>

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

            <!-- Describtion Widget -->
            @if (request('category') and (isset($category->desc_ar) or isset($category->desc_en)))
            <div class="card my-3">
                <h5 class="card-header">{{__('lang.Describtion')}}</h5>
                <div class="card-body">
                    {{ 
                    $category->{'desc_'.app()->getLocale()} ??
                    $category->desc_en ??
                    $category->desc_ar
                    }}
                </div>
            </div>
            @endif

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
            @if (count($relatedTags) > 0)
            <div class="card my-3">
                @if (request('category') ?? request('tag'))
                <h5 class="card-header">{{__('lang.Related tags')}}</h5>
                @else
                <h5 class="card-header">{{__('lang.The most tags used')}}</h5>
                @endif
                <div class="card-body">
                    <div class="row">
                        <div class="flexy">
                            @foreach ($relatedTags as $tag)
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
<script type="text/javascript">
    animation()
</script>
@endpush