@extends('sample.api.layouts.base')

@section('meta')
    <title>{{ config('app.api.name') }}</title>
@endsection

@section('content')
    <div class="flex-center position-ref full-height">
        @include('sample.api.layouts.nav')

        <div class="content">
            <div class="title m-b-md">
                {{ studly_case(config('app.api.name')) }}
            </div>

            <div class="links">
                <a href="{{ route('sample.api.products') }}">Products</a>
                <a href="{{ route('sample.api.orders') }}">Orders</a>
                <a href="{{ route('sample.api.customers') }}">Customers</a>
            </div>
        </div>
    </div>
@endsection
