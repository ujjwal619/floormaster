@extends('admin.layouts.main')

@section('title', 'Modules')

@section('breadcrumb')
  <li class="m-nav__item">
    <a href="{{ route('admin.permissions.index') }}" class="m-nav__link">
      <span class="m-nav__link-text">Permissions</span>
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
  <portlet-content header="Module" subheader="Create" isForm="true">
    <template slot="body">
      <permission-form inline-template method="post"  url="{{ route('admin.permissions.store') }}">
        @include('admin.modules.permission.partials.form')
      </permission-form>
      </template>
    </portlet-content>
@endsection
