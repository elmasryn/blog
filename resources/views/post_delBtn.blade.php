<button name="delete" class="btn btn-danger m-2" type="button" data-toggle="modal" data-target="#del{{ $post->id }}"><i
        class="fas fa-trash-alt mr-1 my-auto"></i> {{ trans('lang.Delete') }}</button>

<!-- Modal -->
<div id="del{{ $post->id }}" tabindex="-1" class="modal fade" role="dialog" aria-labelledby="del" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="del">{{ trans('lang.Delete') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('posts.destroy' , $post->id)}}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <h4>
                        {{ __('lang.Are you sure to delete the post' , ['post' => $post->title]) }}
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