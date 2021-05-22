@extends('admin.layouts.main')

@section('title', 'Job Sources')

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
      <span class="m-nav__link-text">Create</span>
    </a>
  </li>
@endsection

@section('content')
  <portlet-content header="Job Source" subheader="Create" isForm="true">
    <template slot="body">
      <job-source-form inline-template method="post"  url="{{ route('admin.job-sources.store') }}">
        @include('admin.modules.job-source.partials.form')
      </job-source-form>
      </template>
    </portlet-content>
@endsection
