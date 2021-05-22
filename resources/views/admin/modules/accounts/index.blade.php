@extends('admin.layouts.main')

@section('title', 'Accounts')

@section('content')
  <accounts inline-template
  >
    @include('admin.modules.accounts.partials.list')
  </accounts>
@endsection
