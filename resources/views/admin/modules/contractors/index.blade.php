@extends('admin.layouts.main')

@section('title', 'Contractors')

@section('content')
  <contractors inline-template
               @isset($contractor)
                :contractor="{{ $contractor }}"
                :payments="{{ $payments }}"
                :jobs="{{ json_encode($jobs) }}"
               :next="{{ $next ?? 0 }}"
               :previous="{{ $previous ?? 0 }}"
               @endisset
               :suppliers="{{ json_encode($suppliers) }}"
               :liability-account="{{ json_encode($liabilityAccount) }}"
               :cost-of-sales-account="{{ json_encode($costOfSalesAccount) }}"
  >
    @include('admin.modules.contractors.partials.list')
  </contractors>
@endsection
