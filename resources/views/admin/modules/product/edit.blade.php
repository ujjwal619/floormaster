@extends('admin.layouts.main')

@section('title', 'Product')

@section('content')
  <products
          inline-template
          :suppliers="{{ $suppliers }}"
          :selected-supplier="{{ $selectedSupplier }}"
          :categories="{{ json_encode($categories) }}"
          :selected-product="{{ $product }}"
  >
    @include('admin.modules.product.partials.add')
  </products>
@endsection
