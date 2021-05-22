@extends('admin.layouts.main')

@section('title', 'ChequeButt')

@section('content')
  <cheque-butt @if(app('request')->input('remittance')) :remittance-id="{{ app('request')->input('remittance') }}" @endif/>
@endsection
