@extends('admin.layouts.main')

@section('title', 'Add installation complaint')

@section('content')
  <installation-complaints
    inline-template
    :jobs="{{ json_encode($jobs) }}"
    :job="{{ json_encode($job) }}"
    :complaints="{{ json_encode($complaints)  }}"
  >
    @include('admin.modules.installation-complaint.partials.show')
  </installation-complaints>
@endsection
