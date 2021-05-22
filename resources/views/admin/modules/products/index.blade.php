@extends('admin.layouts.main')

@section('title', 'Products')

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
      <span class="m-nav__link-text">List</span>
    </a>
  </li>
@endsection

@section('content')
  <product-list inline-template productindexurl="{{ route('admin.products.type.index') }}">
    <div>
      @include('admin.modules.products.partials.product-types-modal')
      <portlet-tabs>
        <template slot="buttons">
          <a @click="showModal('productTypes')">
            <button
                class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air"
                title="Create new Product"
                data-toggle="tooltip">
              <i class="fa fa-plus"></i>
            </button>
          </a>
        </template>
        <portlet-tab name="labour_products" title="Labour Products">
          <vue-table
              source="{{ route('admin.products.type.table', \App\Constants\General::LABOUR) }}"
              :columns="['name', 'unit_cost', 'action']"
          ></vue-table>
        </portlet-tab>
        <portlet-tab name="material_products" title="Material Products">
          <vue-table
              source="{{ route('admin.products.type.table', \App\Constants\General::MATERIAL) }}"
              :columns="['name', 'unit_cost', 'action']"
          ></vue-table>
        </portlet-tab>
      </portlet-tabs>
    </div>
  </product-list>
@endsection
