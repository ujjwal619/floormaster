@extends('admin.layouts.main')

@section('title', 'Costing Templates')

@section('content')
    <costing-templates
            @if(app('request')->input('template')) :template-id="{{ app('request')->input('template') }}" @endif
    />
@endsection
