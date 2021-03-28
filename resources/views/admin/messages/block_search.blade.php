<div class="card-tools">
    <div class="input-group input-group-sm">
        <input type="text" class="form-control mySearch" placeholder="{{ __('lang.Search Mail') }}">
        <div class="input-group-append">
            <div class="btn btn-primary">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </div>
</div>
<!-- /.card-tools -->

@push('js')
<script>
    search()
</script>
@endpush