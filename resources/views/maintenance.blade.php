@extends('layouts.app')


@section('title' , '| '.__('maintenance'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">{{ __('maintenance') }}</div>
                @if(isset(setting()->website_message))
                <div class="card-body">
                    {!! setting()->website_message !!}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection