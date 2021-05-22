@extends('admin.layouts.main')

@section('title', 'View stock')

@section('content')
  <stocks inline-template url="{{ route('admin.products.stocks.store', [$productType, $product->id]) }}">
    <div class="form-container">
      <div class="col-xsmall-12 col-small-7">
        <h1 style="color: yellow">{{ $product->name }}</h1>
        <div class="table-wrap">
          <portlet-content onlybody>
            <template slot="body">
              <div class="col-xsmall-12" style="max-height: 120px;overflow-y: scroll;">
                <table class="table table-bordered">
                  <tbody>
                  <tr>
                    <td>ID</td>
                    <td>Batch</td>
                    <td>Location</td>
                    <td>Unit Cost</td>
                    <td>Selling Price</td>
                  </tr>
                  @foreach($product->stocks as $key => $stock)
                    <tr>
                      <td>{{ $stock->id }}</td>
                      <td>{{ $stock->batch }}</td>
                      <td>{{ $stock->location }}</td>
                      <td>{{ $stock->unit_cost }}</td>
                      <td>{{ $stock->selling_price }}</td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </template>
          </portlet-content>
        </div>
        {{--Bottom Menus--}}
        <div class="row">
          <div class="col-xsmall-12 col-small-12">
            <portlet-content isform="true" :onlybody="true">
              <template slot="body">
                <a class="btn action-buttons" @click="modals.addStock.show=true">Add Stock</a>
              </template>
            </portlet-content>
          </div>
        </div>
        
        {{--Modal--}}
        @include('admin.modules.products.stock.partials.addStock')
      </div>
  </stocks>
@endsection
