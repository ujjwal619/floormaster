@extends('admin.layouts.main')

@section('title', 'Edit quote')

@section('breadcrumb')
  <li class="m-nav__item">
    <a href="{{ route('admin.quotes.index') }}" class="m-nav__link">
      <span class="m-nav__link-text">Quote</span>
    </a>
  </li>
  <li class="m-nav__separator">
    -
  </li>
  <li class="m-nav__item">
    <a href="#" class="m-nav__link">
      <span class="m-nav__link-text">{{ $quote['customer']['trading_name'] }}</span>
    </a>
  </li>
  <li class="m-nav__separator">
    -
  </li>
  <li class="m-nav__item">
    <a href="#" class="m-nav__link">
      <span class="m-nav__link-text">Add new quote</span>
    </a>
  </li>
@endsection

@section('content')
  <add-quote inline-template
             :next="{{ $next ?? 0 }}"
             :previous="{{ $previous ?? 0 }}"
             :customer="{{ json_encode($quote['customer']) }}"
             :customers="{{ json_encode($customers) }}"
             products="{{ $products }}"
             labourproducts="{{ $labourProducts }}"
             method="patch"
             :quote="{{ json_encode($quote) }}"
             url="{{ route('admin.quotes.update', $quote['id']) }}"
             jobsources="{{ json_encode($jobSources) }}"
             redirecturl="{{ route('admin.quotes.index') }}"
             :staffs="{{ json_encode($staffs) }}"
             :templates="{{ json_encode($templates) }}"
             :booking-types="{{ $bookingTypes }}"
             :site="{{ $site }}"
  >
    @include('admin.modules.quotes.partials.form')
  </add-quote>
@endsection
