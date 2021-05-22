@extends('admin.layouts.main')

@section('title', 'Clients')

@section('content')
  <clients inline-template
  >
    @include('admin.modules.clients.partials.list')
  </clients>
@endsection
