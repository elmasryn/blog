@extends('admin.master')
@section('title' , '| '.__('lang.Home'))
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ trans('lang.Home') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">{{ trans('lang.Statistics') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner row">
                            <div class="col text-left">
                                <h3>{{$activePostCount}}</h3>

                                <p>{{__('lang.Active posts')}}</p>
                            </div>
                            <div class="col text-right text-dark">
                                <h3>{{$notActivePostCount}}</h3>

                                <p>{{__('lang.Not active posts')}}</p>
                            </div>
                        </div>
                        <div class="icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <a href="{{adminurl('posts')}}" class="small-box-footer">{{__('lang.More info')}}
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner row">
                            <div class="col text-left">
                                <h3>{{$activeCategoryCount}}</h3>

                                <p>{{__('lang.Active categories')}}</p>
                            </div>
                            <div class="col text-right text-dark">
                                <h3>{{$notActiveCategoryCount}}</h3>

                                <p>{{__('lang.Not active categories')}}</p>
                            </div>
                        </div>
                        <div class="icon">
                            <i class="fas fa-list"></i>
                        </div>
                        <a href="{{adminurl('categories')}}" class="small-box-footer">{{__('lang.More info')}}
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner row">
                            <div class="col text-left">
                                <h3>{{$activeCommentCount}}</h3>

                                <p>{{__('lang.Active comments')}}</p>
                            </div>
                            <div class="col text-right text-dark">
                                <h3>{{$notActiveCommentCount}}</h3>

                                <p>{{__('lang.Not active comments')}}</p>
                            </div>
                        </div>
                        <div class="icon">
                            <i class="fas fa-comment"></i>
                        </div>
                        <a href="{{adminurl('comments')}}" class="small-box-footer">{{__('lang.More info')}}
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner row">
                            <div class="col text-left text-danger">
                                <h3>{{$usersCount}}</h3>

                                <p>{{__('lang.The users')}}</p>
                            </div>
                            <div class="col text-right text-dark">
                                <h3>{{$editorsCount}}</h3>

                                <p>{{__('lang.The Editors')}}</p>
                            </div>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{adminurl('users')}}" class="small-box-footer">{{__('lang.More info')}}
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->


            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

@endsection