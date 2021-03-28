<div class="card">
    <div class="card-header">
        <h3 class="card-title align-self-center">{{ __('lang.Departments') }}</h3>
        <a href="{{ route(adminview('message_titles.index'))}}" class=" ml-3">{{ trans('lang.Edit') }}
        </a>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            @if (isset($message_titles) && count($message_titles) > 0)
            @foreach ($message_titles as $message_title)
            <li class="nav-item">
                <a href="{{route(adminview('message_titles.show') , $message_title->id)}}"
                    class="nav-link {{Request::is('*/'.$message_title->id) ? 'active' : '' }}">
                    <i class="far fa-circle text-primary"></i>
                    {{ $message_title->{'title_'.app()->getLocale()} }}
                </a>
            </li>
            @endforeach
            @endif
        </ul>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->