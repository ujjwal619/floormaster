@extends('admin.layouts.main')

@section('title', 'Add quotes')

@section('content')
    <add-quote inline-template
               :customers="{{ json_encode($customers) }}"
               @if (!empty($quote))
               :quote="{{ json_encode($quote) }}"
               :customer="{{ json_encode($quote['customer']) }}"
               @endif
               products="{{ json_encode($products) }}"
               labourproducts="{{ json_encode($labourProducts) }}"
               method="post"
               url="{{ route('admin.quotes.store') }}"
               jobsources="{{ json_encode($jobSources) }}"
               redirecturl="{{ route('admin.quotes.index') }}"
               :templates="{{ json_encode($templates) }}"
               :selected-custom-templates="{{ json_encode($selectedTemplates) }}"
    >
        @include('admin.modules.quotes.partials.form')
    </add-quote>
@endsection
