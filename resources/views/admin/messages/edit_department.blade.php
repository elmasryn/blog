@extends('admin.messages.messages')
@section('title' , '| '.__('lang.Edit Departments'))
@section('mailContent')
@section('breadcrumb')
<li class="breadcrumb-item active">{{ trans('lang.Edit Departments') }}</li>
@endsection

<div class="col-md-9">
    <div class="card card-primary card-outline">

        <div class="card-header">
            <h3 class="card-title">{{ __('lang.Edit Departments') }}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0 row">

            <div class="table-responsive mailbox-messages col-10 px-0">
                <table class="table table-hover table-striped">
                    <tbody>
                        @foreach ($message_titles as $message_title)
                        <form method="POST"
                            action="{{ route(adminview('message_titles.update') , $message_title->id)}}">
                            @csrf
                            @method('PUT')
                            <tr>
                                <td class="align-middle">
                                    <input id="title_en" type="text"
                                        value="{{ old('title_en' , optional($message_title)->title_en , '')}}"
                                        class="form-control  @error('title_en') is-invalid @enderror" name="title_en">
                                    @error('title_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </td>
                                <td class="align-middle">
                                    <input id="title_ar" type="text"
                                        value="{{ old('title_ar' , optional($message_title)->title_ar , '')}}"
                                        class="form-control @error('title_ar') is-invalid @enderror" name="title_ar">
                                    @error('title_ar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </td>
                                <td class="align-middle">
                                    <button type="submit" class="btn btn-primary"
                                        name="edit_title">{{ trans('lang.Edit') }}</button>

                                </td>
                            </tr>
                        </form>
                        @endforeach

                    </tbody>
                </table>
                <!-- /.table -->

            </div>

            <div class="table-responsive mailbox-messages col-2 px-0">
                <table class="table table-hover table-striped">
                    <tbody>
                        @foreach ($message_titles as $message_title)
                        <form method="POST"
                            action="{{ route(adminview('message_titles.destroy'), $message_title->id)}}">
                            @csrf
                            @method('DELETE')
                            <tr>
                                <td class="align-middle">
                                    @include('admin.messages.del_btn')
                                </td>
                            </tr>
                        </form>
                        @endforeach

                    </tbody>
                </table>
                <!-- /.table -->

            </div>
            <!-- /.mail-box-messages -->
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.col -->



@endsection