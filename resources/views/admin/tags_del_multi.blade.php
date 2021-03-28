<!-- Modal -->
<div id="multidestroy" tabindex="-1" class="modal fade" role="dialog" aria-labelledby="multidestroy" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="multidestroy">{{ trans('lang.Delete') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger">
                    <div class="no_check d-none">
                        <h4>{{ trans('lang.Please choose some records to delete') }} </h4>
                    </div>
                    <div class="yes_check d-none">
                        <h4>{{ trans('lang.Are you sure to delete the choosen records') }}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="no_check d-none">
                    <button type="button" class="btn btn-default"
                        data-dismiss="modal">{{ trans('lang.Close') }}</button>
                </div>
                <div class="yes_check d-none">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ trans('lang.Close') }}</button>
                    <button type="button" class="btn btn-danger del_multi">{{ trans('lang.Delete') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>