@extends('admin.layouts.main')

@section('title', 'Edit Product')

@section('breadcrumb')
  <li class="m-nav__item">
    <a href="{{ route('admin.products.type.index') }}" class="m-nav__link">
      <span class="m-nav__link-text">Products</span>
    </a>
  </li>
  <li class="m-nav__separator">
    -
  </li>
  <li class="m-nav__item">
    <a href="#" class="m-nav__link">
      <span class="m-nav__link-text">{{ $product->name }}</span>
    </a>
  </li>
  <li class="m-nav__separator">
    -
  </li>
  <li class="m-nav__item">
    <a href="#" class="m-nav__link">
      <span class="m-nav__link-text">Edit</span>
    </a>
  </li>
@endsection

@section('content')
  <product-type-form inline-template
                     url="{{ route('admin.products.type.update', [$productType, $product]) }}"
                     method="patch"
                     selectedvariants="{{ json_encode($variants) }}"
                     producttype="{{ json_encode($product) }}"
                     redirecturl="{{ route('admin.products.type.index') }}"
  >
    @include("admin.modules.products.{$productType}.partials.form")
  </product-type-form>
@endsection
