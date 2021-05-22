@extends('admin.layouts.main')

@section('title', 'Installation complaint')

@section('content')
  <installation-complaints
    inline-template
    :jobs="{{ json_encode($jobs) }}"
    :job="{{ json_encode($job) }}"
    :complaint="{{ json_encode($installationComplaint) }}"
    :complaints="{{ json_encode($complaints)  }}"
  >
    @include('admin.modules.installation-complaint.partials.show')
  </installation-complaints>
@endsection
