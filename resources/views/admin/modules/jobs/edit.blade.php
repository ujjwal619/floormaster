@extends('admin.layouts.main')

@section('title', 'Edit job')

@section('breadcrumb')
  <li class="m-nav__item">
    <a href="{{ route('admin.jobs.index') }}" class="m-nav__link">
      <span class="m-nav__link-text">Job</span>
    </a>
  </li>
  <li class="m-nav__separator">
    -
  </li>
  <li class="m-nav__item">
    <a href="#" class="m-nav__link">
      <span class="m-nav__link-text">{{ $job['trading_name'] }}</span>
    </a>
  </li>
  <li class="m-nav__separator">
    -
  </li>
  <li class="m-nav__item">
    <a href="#" class="m-nav__link">
      <span class="m-nav__link-text">Edit Job</span>
    </a>
  </li>
@endsection

@section('content')
  <add-job inline-template
           :next="{{ $next ?? 0 }}"
           :previous="{{ $previous ?? 0 }}"
           :customer="{{ json_encode($job['customer']) }}"
           products="{{ $products }}"
           labourproducts="{{ $labourProducts }}"
           method="patch"
           :job="{{ json_encode($job) }}"
           url="{{ route('admin.jobs.update', $job['id']) }}"
           jobsources="{{ json_encode($jobSources) }}"
           redirecturl="{{ route('admin.jobs.index') }}"
           :templates="{{ json_encode($templates) }}"
           :staffs="{{ json_encode($staffs) }}"
           :invoices="{{ json_encode($invoices) }}"
           :booking-types="{{ $bookingTypes }}"
           :bookings="{{ $bookings }}"
           :complaints="{{ $complaints }}"
           :site="{{ $site }}"
  >
    @include('admin.modules.jobs.partials.form')
  </add-job>
@endsection
