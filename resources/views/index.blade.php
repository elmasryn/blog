@extends('layouts.app')

@section('title' , '| '.__('lang.Home'))

@section('content')
<div class="container">

    @if (count($posts) > 0)
    <div class="row justify-content-center py-5">
        <h1>{{ trans('lang.Latest added posts') }}</h1>
        <div class="container-fluid">
            <div class="row mt-5">
                @foreach ($posts as $post)
                <div class="col-md-4 mb-3">
                    <div class="mx-3 card">
                        <a href="{{url('posts/'.$post->slug)}}">
                            <img class="card-img-top" width="315px" height="252px" src="@isset($post->thumbnail) {{asset($post->thumbnail)}} 
                                @else 
                                {{url('img/thumbnail/default.jpg')}} 
                                @endisset
                                " title="{{$post->title}}">
                        </a>
                        {{--315*252 <<<<<<<<<< will be set--}}
                        <div class="card-body">
                            <h4 class="card-title">{{$post->title}}</h4>
                            <p class="card-text">{{str_limit(strip_tags($post->body),100)}}</p>
                            <a href="{{url('posts/'.$post->slug)}}"
                                class="btn btn-warning">{{ trans('lang.Full Post') }}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @isset($post_middle)
    <div class="row align-items-center">
        <div class="col-md-6"><img class="img-thumbnail"
                src="@isset($post_middle->thumbnail) {{asset($post_middle->thumbnail)}} @else {{url('img/thumbnail/default.jpg')}} @endisset">
        </div>
        <div class="col-md-6">
            <h3>{{$post_middle->title}}</h3>
            <div class="getting-started-info">
                <p>{{str_limit(strip_tags($post_middle->body),150)}}</p>
            </div><button class="btn btn-outline-danger btn-lg" type="button"
                onclick="location.href='{{url('posts/'.$post_middle->slug)}}'">{{ trans('lang.Full Post') }}</button>
        </div>
    </div>
    @endisset

    @if (count($posts_slide) > 0)
    <div id="demo" class="carousel slide my-5" data-ride="carousel">
        <ul class="carousel-indicators">
            @foreach ($posts_slide as $post_slide)
            <li data-target="#demo" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
            @endforeach
        </ul>
        <div class="carousel-inner">
            @foreach ($posts_slide as $post_slide)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <a href="{{url('posts/'.$post_slide->slug)}}">
                    <img src="@isset($post_slide->thumbnail) {{asset($post_slide->thumbnail)}} @else {{url('img/thumbnail/default.jpg')}} @endisset"
                        alt="Los Angeles" width="1100" height="500">
                </a>
                <div class="carousel-caption">
                    <a href="{{url('posts/'.$post_slide->slug)}}" class="text-light">
                        <h3>{{$post_slide->title}}</h3>
                    </a>
                    <p>{{str_limit(strip_tags($post_slide->body),150)}}</p>
                </div>
            </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#demo" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>
    @endif

</div>
@endsection

@push('js')
<script type="text/javascript">
    animation()
</script>
@endpush