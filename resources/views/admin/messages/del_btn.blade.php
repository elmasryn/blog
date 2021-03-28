<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-danger" data-toggle="modal"
    data-target="#del_title{{ $message_title->id }}">{{ trans('lang.Delete') }}</button>

<!-- Modal -->
<div id="del_title{{ $message_title->id }}" tabindex="-1" class="modal fade" role="dialog" aria-labelledby="del_title"
    aria-hidden="true">
    <div class="modal-dialog" role="document">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="del_title">{{ trans('lang.Delete') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route(adminview('message_titles.destroy') , $message_title->id)}}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <h4>
                        {{ __('lang.Are you sure to delete the department' , ['department' => $message_title->{'title_'.app()->getLocale()}]) }}
                    </h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ trans('lang.Close') }}</button>
                    <button type="submit" class="btn btn-danger">{{ trans('lang.Delete') }}</button>
                </div>
            </form>
        </div>

    </div>
</div>