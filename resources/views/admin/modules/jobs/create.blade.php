@extends('admin.layouts.main')

@section('title', 'Add job')

@section('content')
  <add-job inline-template
           :customers="{{ json_encode($customers) }}"
           products="{{ $products }}"
           labourproducts="{{ $labourProducts }}"
           method="post"
           url="{{ route('admin.jobs.store') }}"
           jobsources="{{ json_encode($jobSources) }}"
           redirecturl="{{ route('admin.jobs.index') }}"
           :templates="{{ json_encode($templates) }}"
           :selected-custom-templates="{{ json_encode($selectedTemplates) }}"
  >
    @include('admin.modules.jobs.partials.form')
  </add-job>
@endsection
