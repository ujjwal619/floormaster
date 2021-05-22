@extends('admin.layouts.main')

@section('title', 'Create Product')

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
      <span class="m-nav__link-text">Create</span>
    </a>
  </li>
@endsection

@section('content')
  <product-type-form inline-template
                     url="{{ route('admin.products.type.store', $productType) }}"
                     redirecturl="{{ route('admin.products.type.index') }}"
  >
    @include("admin.modules.products.{$productType}.partials.form")
  </product-type-form>
@endsection
