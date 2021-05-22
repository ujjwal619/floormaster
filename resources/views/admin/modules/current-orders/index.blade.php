@extends('admin.layouts.main')

@section('title', 'Current Orders')

@section('content')
    <current-orders inline-template
    @if(app('request')->segment(2)) :order-id="{{ app('request')->segment(2) }}" @endif
    >
        @include('admin.modules.current-orders.partials.list')
    </current-orders>
@endsection
