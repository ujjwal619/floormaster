@extends('admin.layouts.main')

@section('title', 'Edit template')

@section('content')
    <add-template inline-template
                  template="{{ $template }}"
                  products="{{ $products }}"
                  labourproducts="{{ $labourProducts }}"
                  method="patch"
                  url="{{ route('admin.templates.update', $template->id) }}"
                  redirecturl="{{ route('admin.templates.index') }}"
    >
        @include('admin.modules.template.partials.form')
    </add-template>
@endsection
