@extends('admin.layouts.main')

@section('title', 'Delivered Orders')

@section('content')
    <delivered-orders inline-template>
      @include('admin.modules.delivered-orders.partials.list')
    </delivered-orders>
@endsection
