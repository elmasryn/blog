<button class="btn btn-danger btn-sm d-flex flex-nowrap" type="button" data-toggle="modal"
    data-target="#delWebContent{{ $id }}"><i class="fas fa-trash-alt mr-1 my-auto"></i> {{ trans('lang.Delete') }}</button>

<!-- Modal -->
<div id="delWebContent{{ $id }}" tabindex="-1" class="modal fade" role="dialog" aria-labelledby="del" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="del">{{ trans('lang.Delete') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route(adminview('website_contents.destroy') , $id)}}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <h4>
                        {{ __('lang.Are you sure to delete the content') }}
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