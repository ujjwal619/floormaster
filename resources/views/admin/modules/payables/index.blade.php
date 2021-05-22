@extends('admin.layouts.main')

@section('title', 'Payables')

@section('content')
    <payables
      @if(app('request')->input('payable')) :payable-id="{{ app('request')->input('payable') }}" @endif
    />
@endsection
