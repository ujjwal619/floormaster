@extends('admin.layouts.main')

@section('title', 'Security')

@section('content')
  <security inline-template
  >
    @include('admin.modules.security.partials.list')
  </security>
@endsection
