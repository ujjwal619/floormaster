@extends('admin.layouts.main')

@section('title', 'Suppliers')

@section('content')
  <suppliers inline-template
     @if(app('request')->input('supplier')) :supplier-id="{{ app('request')->input('supplier') }}" @endif
  >
    @include('admin.modules.suppliers.list') 
  </suppliers>
@endsection
