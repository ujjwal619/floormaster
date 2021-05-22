@extends('admin.layouts.main')

@section('title', 'Add new terms and condition.')

@section('content')
  <add-term inline-template
            method="post"
            url="{{  route('admin.terms.store') }}"
            redirecturl="{{ route('admin.terms.index') }}"
  >
    @include('admin.modules.settings.terms.partials.form')
  </add-term>
@endsection
