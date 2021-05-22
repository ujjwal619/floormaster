@extends('admin.layouts.main')

@section('title', 'Edit Job Source')

@section('breadcrumb')
  <li class="m-nav__item">
    <a href="{{ route('admin.job-sources.index') }}" class="m-nav__link">
      <span class="m-nav__link-text">Job Sources</span>
    </a>
  </li>
  <li class="m-nav__separator">
    -
  </li>
  <li class="m-nav__item">
    <a href="#" class="m-nav__link">
      <span class="m-nav__link-text">Edit</span>
    </a>
  </li>
@endsection

@section('content')
  <job-source-form inline-template
                   method="put"
                   jobsource="{{ json_encode($jobSource) }}"
                   redirecturl="{{ route('admin.job-sources.index') }}"
                   url="{{ route('admin.job-sources.update', $jobSource->id) }}">
    <portlet-content header="Job Source" subheader="Edit" isForm="true">
      <template slot="body">
        @include('admin.modules.job-source.partials.form')
      </template>
    </portlet-content>
  </job-source-form>
@endsection
