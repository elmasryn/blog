<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('lang.Add category') }}</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <form method="POST" action="{{ route(adminview('message_titles.store'))}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group p-3">
                <label for="title_en">{{ trans('lang.Title name by English') }}</label>
                <input id="title_en" type="text" value="{{ old('title_en' , '')}}"
                    class="form-control @error('title_en') is-invalid @enderror" name="title_en">
                @error('title_en')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group p-3">
                <label for="title_ar">{{ trans('lang.Title name by Arabic') }}</label>
                <input type="text" id="title_ar" value="{{ old('title_ar', '')}}"
                    class="form-control @error('title_ar') is-invalid @enderror" name="title_ar">
                @error('title_ar')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group p-3">
                <button type="submit" class="btn btn-primary">{{ trans('lang.Add') }}</button>
            </div>
        </form>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->