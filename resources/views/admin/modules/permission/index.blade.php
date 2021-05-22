@extends('admin.layouts.main')

@section('title', 'Permissions')

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
      <span class="m-nav__link-text">List</span>
    </a>
  </li>
@endsection

@section('content')
  <portlet-content header="Permissions" subheader="List" isForm="false">
    <template slot="action_button">
      <div>
        <a href="{{ route('admin.permissions.create') }}">
          <button
              class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air"
              title="Add new Permission"
              data-toggle="tooltip"
          >
            <i class="fa fa-plus"></i>
          </button>
        </a>
      </div>
    </template>
    <template slot="body">
      <div style="padding: 10px;">
        <vue-table
            source="{{ route('admin.permissions.table') }}"
            :columns="['name', 'title', 'action']"
        ></vue-table>
      </div>
    </template>
  </portlet-content>
@endsection
