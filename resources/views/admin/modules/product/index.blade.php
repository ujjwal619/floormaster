@extends('admin.layouts.main')

@section('title', 'Product')

@section('content')
    <products
      inline-template
      :products="{{ $products }}"
      :selected-supplier="{{ $selectedSupplier }}"
      :categories="{{ json_encode($categories) }}"
    >
        @include('admin.modules.product.partials.list')
    </products>
@endsection
