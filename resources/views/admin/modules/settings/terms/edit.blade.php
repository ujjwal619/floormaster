@extends('admin.layouts.main')

@section('title', 'Edit new terms and condition.')

@section('content')
  <add-term inline-template
            method="patch"
            url="{{  route('admin.terms.update', $term->id) }}"
            redirecturl="{{ route('admin.terms.index') }}"
            :term="{{ json_encode($term) }}"
  >
    @include('admin.modules.settings.terms.partials.form')
  </add-term>
@endsection
