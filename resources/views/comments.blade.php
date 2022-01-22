@push('css')
    <link href="/css/comments.css" rel="stylesheet">
@endpush
<div class="container">


    <div class="justify-content-center mt-100 mb-100">
        @if (count($comments) > 0)
            <div id="comment-" class="comment- card">
                <div class="card-body text-center">
                    <h4 class="card-title">{{ trans('lang.Latest comments') }}</h4>
                </div>
                <div class="comment-widgets">

                    @foreach ($comments as $comment)

                        <!-- Comment Row -->
                        <div id="comment{{ $comment->id }}" class="d-flex flex-row comment-row m-t-0">
                            <div class="p-2">
                                @empty($comment->user->profile->avatar)
                                    @isset($comment->user)
                                        <a href="{{ url('profile/' . $comment->user_id) }}">
                                            <img src="{{ url('img/avatar/default.png') }}" alt="{{ $comment->name }}" width="50"
                                                height="50" class="rounded-circle">
                                        </a>
                                    @else
                                        <img src="{{ url('img/avatar/default.png') }}" alt="{{ $comment->name }}" width="50"
                                            height="50" class="rounded-circle">
                                    @endisset
                                @else
                                    <a href="{{ url('profile/' . $comment->user_id) }}">
                                        <img src="{{ url($comment->user->profile->avatar) }}" alt="{{ $comment->name }}"
                                            width="50" height="50" class="rounded-circle">
                                    </a>
                                @endempty
                            </div>
                            <div class="comment-text w-100">
                                <h6 class="font-medium">{{ $comment->name }}</h6>
                                <span class="m-b-15 d-block">{{ $comment->body }} </span>
                                <div class="comment-footer">
                                    @if ($comment->getRawOriginal('status') == '0')
                                        <div class="alert alert-danger m-2 text-center d-block" role="alert">
                                            <strong>{{ __('lang.The comment is under review and has not been published yet') }}</strong>
                                        </div>
                                    @endif
                                    <span
                                        class="text-muted float-right">{{ $comment->created_at->format('F j, Y') }}</span>
                                    @canany(['admin', 'ownerTime'], $comment)
                                        <button type="button"
                                            class="btn btn-cyan btn-sm editCommentBtn">{{ trans('lang.Edit') }}</button>
                                    @endcanany
                                    @can('admin')
                                        @include('comment_delBtn')
                                        @if ($comment->getRawOriginal('status') == '1')
                                            <button type="button" class="btn btn-warning btn-sm publish"
                                                commentId="{{ $comment->id }}"
                                                commentStatus="{{ $comment->getRawOriginal('status') }}">{{ trans('lang.Hide') }}</button>
                                        @else
                                            <button type="button" class="btn btn-success btn-sm publish"
                                                commentId="{{ $comment->id }}"
                                                commentStatus="{{ $comment->getRawOriginal('status') }}">{{ trans('lang.Publish') }}</button>
                                        @endif
                                    @endcan
                                </div>
                                @canany(['admin', 'ownerTime'], $comment)
                                    <form class="d-none editCommentForm" action="{{ route('editComment', $comment->id) }}"
                                        method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group p-3">
                                            <textarea id="body" class="form-control
                                    @error('body') is-invalid @enderror" name="body" cols="40"
                                                rows="4">{{ old('body', optional($comment)->body, '') }}</textarea>
                                            @error('body')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <button type="submit"
                                                class="btn btn-primary">{{ trans('lang.Edit content') }}</button>
                                        </div>
                                    </form>
                                @endcanany
                            </div>
                        </div> <!-- Comment Row -->
                        <hr class="mx-5">

                    @endforeach

                    <div class="d-flex justify-content-center">{{ $comments->links() }}
                    </div>

                </div>
            </div><!-- Card -->

        @endif

        <!-- Comment insert -->
        <div class="comment- card">
            <div class="container p-4">
                <form method="POST" action="{{ route('storeComment', $post->id) }}">
                    @csrf
                    <div class="form-group w-50">
                        <label for="name">
                            {{ trans('lang.Name') }}</label>
                        <input type="text" value="{{ old('name', optional(Auth::user())->name, '') }}"
                            class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                            placeholder="{{ trans('lang.Enter name') }}" required="required" />
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="body">
                            {{ trans('lang.The comment') }}</label>
                        <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror"
                            rows="5" cols="25" required="required"
                            placeholder="{{ trans('lang.Body') }}">{{ old('body', '') }}</textarea>
                        @error('body')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-info float-right">
                            {{ trans('lang.Send comment') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Comment insert -->

    </div>

</div>

@push('js')
    <script type="text/javascript">
        publishComment()
        editComment()
    </script>
@endpush
