@extends('admin.layouts.main')

@section('title', 'Add template')

@section('content')
    <add-template inline-template
               products="{{ $products }}"
               labourproducts="{{ $labourProducts }}"
               method="post"
               url="{{ route('admin.templates.store') }}"
               redirecturl="{{ route('admin.templates.index') }}"
    >
        @include('admin.modules.template.partials.form')
    </add-template>
@endsection
