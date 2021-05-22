@extends('admin.layouts.main')

@section('title', 'Edit Permission')

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
      <span class="m-nav__link-text">Edit</span>
    </a>
  </li>
@endsection

@section('content')
  <permission-form inline-template
                   method="put"
                   permission="{{ json_encode($permission) }}"
                   redirecturl="{{ route('admin.permissions.index') }}"
                   url="{{ route('admin.permissions.update', $permission->id) }}">
    <portlet-content header="Permission" subheader="Edit" isForm="true">
      <template slot="body">
        @include('admin.modules.permission.partials.form')
      </template>
    </portlet-content>
  </permission-form>
@endsection
