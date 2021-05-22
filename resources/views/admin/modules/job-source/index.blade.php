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
      <span class="m-nav__link-text">List</span>
    </a>
  </li>
@endsection

@section('content')
  <portlet-content header="Job Sources" subheader="List" isForm="false">
    <template slot="action_button">
      <div>
        <a href="{{ route('admin.job-sources.create') }}">
          <button
              class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air"
              title="Add new job Source"
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
            source="{{ route('admin.job-sources.table') }}"
            :columns="['title', 'name', 'action']"
        ></vue-table>
      </div>
    </template>
  </portlet-content>
@endsection
