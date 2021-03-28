<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{url('')}}" target="_blank" class="nav-link">{{ trans('lang.Home') }}</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">{{ trans('lang.Logout') }}</a>

            <form id="logout-form" action="{{ route('admin/logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-envelope"></i>
                <span class="badge badge-warning navbar-badge">{{count($messages)}}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">
                    {{ trans_choice('lang.New messages',count($messages),['value'=>count($messages)]) }}</span>
                <div class="dropdown-divider"></div>
                @foreach ($messages->take(6) as $message)
                <a href="{{route(adminview('messages.show') , $message->id)}}" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> {{ trans('lang.By') }} {{$message->name}}
                    <span class="float-right text-muted text-sm">
                        {{mailSince($messages)[$message->id]}}
                </a>
                @endforeach
                <div class="dropdown-divider"></div>
                <a href="{{adminurl('messages/unread')}}"
                    class="dropdown-item dropdown-footer">{{ trans('lang.See All messages') }}</a>
            </div>
        </li>

        <!-- change language -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" title="{{ trans('lang.Change the language') }}">
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
</nav>