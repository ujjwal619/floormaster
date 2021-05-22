@extends('admin.layouts.main')

@section('title', 'Stocks')

@section('content')
    <stocks inline-template
      :color="{{ json_encode($color) }}"
      :product="{{ json_encode($product) }}"
      :supplier="{{ json_encode($supplier) }}"
      :current-stock-list="{{ json_encode($currentStocks) }}"
      :future-stocks="{{ json_encode($futureStocks) }}"
      :stock="{{ json_encode($stock) }}"
      :products="{{ json_encode($products) }}"
    >
        @include('admin.modules.stock.partials.list')
    </stocks>
@endsection
