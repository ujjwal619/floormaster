@extends('admin.layouts.main')

@section('title', 'Setup')

@section('content')
  <setup inline-template
  >
    @include('admin.modules.setup.partials.list')
  </setup>
@endsection
