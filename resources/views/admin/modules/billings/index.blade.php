@extends('admin.layouts.main')

@section('title', 'Billings')

@section('content')
	<billings inline-template
    @if(app('request')->input('invoice')) :invoice-id="{{ app('request')->input('invoice') }}" @endif
  >
    @include('admin.modules.billings.partials.list')
  </billings>
@endsection
