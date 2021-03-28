<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('lang.Folders') }}</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="{{route(adminview('messages.index'))}}"
                    class="nav-link {{Request::is('*/messages') ? 'active' : '' }}">
                    <i class="fas fa-inbox"></i> {{ __('lang.Inbox') }}
                    <span class="badge bg-dark float-right mt-1">{{$messagesCount}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{adminurl('messages/unread')}}"
                    class="nav-link {{Request::is('*/messages/unread') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> {{ __('lang.Unread messages') }}
                    <span class="badge bg-warning float-right mt-1">{{$unreadMessagesCount}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{adminurl('messages/read')}}"
                    class="nav-link {{Request::is('*/messages/read') ? 'active' : '' }}">
                    <i class="far fa-envelope-open"></i> {{ __('lang.Read messages') }}
                    <span class="badge bg-success float-right mt-1">{{$readMessagesCount}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{adminurl('messages/trash')}}"
                    class="nav-link {{Request::is('*/messages/trash') ? 'active' : '' }}">
                    <i class="far fa-trash-alt"></i> {{ __('lang.Trash') }}
                    <span class="badge bg-danger float-right mt-1">{{$trashedMessagesCount}}</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->