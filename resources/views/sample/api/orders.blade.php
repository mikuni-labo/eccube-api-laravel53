@extends('sample.api.layouts.base')

@section('meta')
    <title>{{ config('app.api.name') }}</title>
@endsection

@section('content')
    <div class="flex-center position-ref full-height">
        @include('sample.api.layouts.nav')

        <div class="content">
            <div class="title m-b-md">
                {{ studly_case('orders') }}
            </div>

            <div class="links">
                o
            </div>
        </div>
    </div>
@endsection
