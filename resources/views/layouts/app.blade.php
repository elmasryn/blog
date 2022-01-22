<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name=”description” content="{{optional(setting())->description}} @yield('description')">
    <meta name="keywords" content="{{optional(setting())->keywords}} @yield('keywords')">

    <title>{{ setting()->{'website_'.app()->getLocale()} ?? config('app.name') ?? '' }} @yield('title')</title>

    <!-- Icon -->
    <link rel="icon" href="{{optional(setting())->icon}}">

    <!-- fonts -->
    <link href="{{asset('')}}/dist/fonts/fonts.googleapis.css" rel="stylesheet">

    <!-- fontawesome -->
    <link rel="stylesheet" href="{{asset('')}}/plugins/fontawesome-free/css/all.min.css">

    @if (App::isLocale('en'))
    <!-- English bootstrap style -->
    <link href="{{ asset('dist/css/bootstrap.min.css') }}" rel="stylesheet">
    @else
    <!-- Arabic bootstrap style -->
    <link href="{{ asset('dist/css/bootstrap.arabic.css') }}" rel="stylesheet">
    @endif

    <!-- Custom style -->
    <link href="{{ asset('css/mystyle.css') }}" rel="stylesheet">

    @stack('css')
    <!-- Styles -->

</head>

<body>

    <nav class="navbar navbar-expand-md navbar-white navbar-light font-weight-bold fixed-top">
        <div class="overlay"></div>
        <div class="container">
            <a class="navbar-brand text-light " href="{{ url('/') }}">
                {{  setting()->{'website_'.app()->getLocale()} ?? config('app.name') ?? 'Website Name' }} </a> <button
                class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item text-light" role="presentation">
                        <a class="nav-link text-light active" href="{{ url('/') }}">{{ __('lang.Home') }}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-light" href="{{ url('/categories') }}">{{ __('lang.Categories') }}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-light" href="{{ url('/posts') }}">{{ __('lang.Posts') }}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-light" href="{{ url('/aboutUs') }}">{{ __('lang.About us') }}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-light" href="{{ url('/contactUs') }}">{{ __('lang.Contact us') }}</a>
                    </li>


                    <!-- Authentication Links -->
                    @guest

                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('login') }}">{{ __('lang.Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('register') }}">{{ __('lang.Register') }}</a>
                    </li>

                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link text-light dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                            <a class="dropdown-item"
                                href="{{ url('profile/'.auth()->id()) }}">{{ __('lang.Profile') }}</a>
                            @role('Admin')
                            <a class="dropdown-item" href="{{ adminurl('') }}">{{ __('lang.Admin panel') }}</a>
                            @endrole
                            <!-- admin Widget -->
                            @canany(['admin', 'editor'])
                            <a class="dropdown-item" href="{{url('posts/create')}}">{{ __('lang.Add new Post') }}</a>
                            @endcanany
                            <a class="dropdown-item" href="#" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('lang.Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest

                    <li class="nav-item dropdown">
                        <a class="nav-link text-light" data-toggle="dropdown" href="#"
                            title="{{ trans('lang.Change the language') }}">
                            <i class="fas fa-globe"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span class="dropdown-item dropdown-header">{{ trans('lang.Change the language') }}</span>
                            <div class="dropdown-divider"></div>
                            @foreach (locales() as $key => $value)
                            <a href="{{url($key)}}" class="dropdown-item">
                                <i class="fas fa-flag mr-2"></i> {{ $value }}
                            </a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="header-img">
        @isset($post_header)
        <div class="text mx-auto">
            <h2>{{ $post_header->title }}</h2>
            <p>{{ str_limit(strip_tags($post_header->body),150) }}</p><a href="{{url('posts/'.$post_header->slug)}}"
                class="btn btn-outline-light btn-lg">{{ __('lang.Full Post') }}</a>
        </div>
        @endisset
        <div class="overlay"></div>

    </header>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="pt-4 text-light bg-dark">

        <!-- Footer Links -->
        <div class="container text-center text-md-left">

            <!-- Grid row -->
            <div class="row">


                <!-- Grid column -->
                <div class="col-md-4 mx-auto">

                    <!-- Content -->
                    <h5 class="font-weight-bold text-nowrap mt-3 mb-4">{{ $footer_head ?? '' }}</h5>
                    <p>{{ $footer_content ?? '' }}</p>

                </div>
                <!-- Grid column -->

                <hr class="clearfix w-100 d-md-none">

                <!-- Grid column -->
                <div class="col-md-2 mx-auto">

                    <!-- Links -->
                    <h5 class="font-weight-bold text-nowrap mt-3 mb-4">{{ $footer_head_1 ?? '' }}</h5>

                    <ul class="list-unstyled">
                        @if (count($footer_col_1) > 0)
                        @foreach ($footer_col_1 as $link => $value)
                        <li>
                            @if ($link == Null)
                            <a href="#">{{ $value ??  ''}}</a>
                            @else
                            <a href="{{$link}}">{{ $value ??  ''}}</a>
                            @endif
                        </li>
                        @endforeach
                        @endif
                    </ul>

                </div>
                <!-- Grid column -->

                <hr class="clearfix w-100 d-md-none">

                <!-- Grid column -->
                <div class="col-md-2 mx-auto">

                    <!-- Links -->
                    <h5 class="font-weight-bold text-nowrap mt-3 mb-4">{{ $footer_head_2 ?? ''  }}</h5>

                    <ul class="list-unstyled">
                        @if (count($footer_col_2) > 0)
                        @foreach ($footer_col_2 as $link => $value)
                        <li>
                            @if ($link == Null)
                            <a href="#">{{ $value ??  ''}}</a>
                            @else
                            <a href="{{$link}}">{{ $value ??  ''}}</a>
                            @endif
                        </li>
                        @endforeach
                        @endif
                    </ul>

                </div>
                <!-- Grid column -->

                <hr class="clearfix w-100 d-md-none">

                <!-- Grid column -->
                <div class="col-md-2 mx-auto">

                    <!-- Links -->
                    <h5 class="font-weight-bold text-nowrap mt-3 mb-4">{{ $footer_head_3 ?? ''  }}</h5>

                    <ul class="list-unstyled">
                        @if (count($footer_col_3) > 0)
                        @foreach ($footer_col_3 as $link => $value)
                        <li>
                            @if ($link == Null)
                            <a href="#">{{ $value ??  ''}}</a>
                            @else
                            <a href="{{$link}}">{{ $value ??  ''}}</a>
                            @endif
                        </li>
                        @endforeach
                        @endif
                    </ul>

                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->

        </div>
        <!-- Footer Links -->

        @guest
        <hr>

        <!-- Call to action -->
        <ul class="list-unstyled list-inline text-center py-2">
            <li class="list-inline-item">
                <h5 class="mb-1">{{ __('lang.Register for free') }}</h5>
            </li>
            <li class="list-inline-item">
                <a href="{{ route('register') }}" class="btn btn-danger btn-rounded">{{ __('lang.Sign up') }}</a>
            </li>
        </ul>
        <!-- Call to action -->
        @endguest

        <hr>

        <!-- Social buttons -->
        <ul class="list-unstyled list-inline text-center">
            @isset($facebook)
            <li class="list-inline-item">
                <a href="{{$facebook ?? '#'}}" class="btn-floating btn-fb mx-1">
                    <i class="fab fa-facebook-f"> </i>
                </a>
            </li>
            @endisset
            @isset($twitter)
            <li class="list-inline-item">
                <a href="{{$twitter ?? '#'}}" class="btn-floating btn-tw mx-1">
                    <i class="fab fa-twitter"> </i>
                </a>
            </li>
            @endisset
            @isset($google)
            <li class="list-inline-item">
                <a href="{{$google ?? '#'}}" class="btn-floating btn-gplus mx-1">
                    <i class="fab fa-google-plus-g"> </i>
                </a>
            </li>
            @endisset
            @isset($linkedin)
            <li class="list-inline-item">
                <a href="{{$linkedin ?? '#'}}" class="btn-floating btn-li mx-1">
                    <i class="fab fa-linkedin-in"> </i>
                </a>
            </li>
            @endisset
            @isset($gmail)
            <li class="list-inline-item">
                <a href="{{$gmail ?? '#'}}" class="btn-floating btn-dribbble mx-1">
                    <i class="fab fa-dribbble"> </i>
                </a>
            </li>
            @endisset
            @if (count($other_social) > 0)
            @foreach ($other_social as $link => $value)
            @if ($link != Null)
            <li class="list-inline-item">
                <a href="{{$link ?? '#'}}" class="btn-floating btn-dribbble mx-1">
                    @if ($value == Null)
                    <i class="fab fa-dribbble"> </i>
                    @else
                    {!!$value!!}
                    @endif
                </a>
            </li>
            @endif
            @endforeach
            @endif
        </ul>
        <!-- Social buttons -->

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2020 {{ __('lang.Copyright') }}:
            <a href="mailto:elmasry_n@hotmail.com">Mohamed El Masry </a>
        </div>
        <!-- Copyright -->

    </footer>

    <!-- Footer -->

    <!-- jQuery -->
    <script src="{{asset('')}}/js/jquery.min.js"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> --}}

    <script src="{{asset('')}}/dist/js/bootstrap.js"></script>

    <!-- sweetalert2 -->
    <script src="{{asset('')}}/plugins/sweetalert2/sweetalert2@9.js"></script>

    <script src="{{asset('')}}/js/my.js"></script>

    @stack('js')

    @include('alerts')
</body>
{{-- copyright reserved to elmasry_n@hotmail.com --}}
</html>
