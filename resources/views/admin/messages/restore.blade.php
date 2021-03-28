<!-- Modal -->
<div id="restore_mail{{ $mail->id }}" tabindex="-1" class="modal fade" role="dialog" aria-labelledby="restore_mail"
    aria-hidden="true">
    <div class="modal-dialog" role="document">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restore_mail">{{ trans('lang.Restore the trash') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route(adminview('messages.restore') , $mail->id)}}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <h4>
                        {{ trans('lang.Are you sure to restore this mail') }}
                    </h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ trans('lang.Close') }}</button>
                    <button type="submit" class="btn btn-success">{{ trans('lang.Restore the trash') }}</button>
                </div>
            </form>
        </div>

    </div>
</div>