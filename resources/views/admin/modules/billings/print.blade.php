@extends('admin.layouts.main')

@section('title', 'Print')

@section('content')
	<print inline-template
    :invoice="{{ json_encode($invoice) }}"
  >
    @include('admin.modules.billings.partials.print-list')
  </print>
@endsection
