@extends('admin.layouts.main')

@section('title', 'Roles  and Permissions')

@section('breadcrumb')
  <li class="m-nav__item">
    <a href="{{ route('admin.permissions.manage') }}" class="m-nav__link">
      <span class="m-nav__link-text">Roles and Permissions</span>
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
  <portlet-content header="Roles and Permissions" subheader="Association" isForm="false">
    <template slot="body">
      <role-permission-association inline-template permissionbaseurl="{{ route('admin.permissions.index') }}">
        <table class="table">
          <thead>
          <th>Permissions<i class="fa fa-arrow-down"></i>  / Roles <i class="fa fa-arrow-right"></i> </th>
          @foreach($roles as $role)
            <th style="text-align:center;">{{ $role->name }}</th>
          @endforeach
          </thead>
          <tbody>
          @foreach($permissions as $permission)
            <tr>
              <td>{{ $permission->name }}</td>
              @foreach($roles as $role)
                <td style="text-align:center;">
                  <label class="m-checkbox">
                    <input type="checkbox" class="m-checkbox--air"
                           @click="togglePermission({{ $role->id }}, {{ $permission->id }})" {{ $role->hasPermissionTo($permission) ? 'checked' : '' }}>
                    <span></span>
                  </label>
                </td>
              @endforeach
            </tr>
          @endforeach
          </tbody>
        </table>
      </role-permission-association>
    </template>
  </portlet-content>
@endsection
