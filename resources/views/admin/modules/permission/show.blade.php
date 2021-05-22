@extends('admin.layouts.main')

@section('title', 'Modules')

@section('breadcrumb')
  <li class="m-nav__item">
    <a href="{{ route('admin.modules.index') }}" class="m-nav__link">
      <span class="m-nav__link-text">Modules</span>
    </a>
  </li>
  <li class="m-nav__separator">
    -
  </li>
  <li class="m-nav__item">
    <a href="#" class="m-nav__link">
      <span class="m-nav__link-text">Details</span>
    </a>
  </li>
@endsection

@section('content')
  <portlet-content header="Module" subheader="Details" isForm="false">
    <template slot="action_button">
      <div>
        <a href="{{ route('admin.modules.edit', $module->id) }}">
          <button
              class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air"
              title="Edit Module"
              data-toggle="tooltip"
          >
            <i class="fa fa-pencil"></i>
          </button>
        </a>
      </div>
    </template>
    <template slot="body">
      <div style="padding: 10px;">
        <table class="table">
          <tbody>
          <tr>
            <td><strong>Title</strong></td>
            <td>{{ ucwords($module->title) }}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </template>
  </portlet-content>
@endsection
