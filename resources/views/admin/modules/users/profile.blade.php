@extends('admin.layouts.main')

@section('title', 'Profile')

@section('breadcrumb')
  <li class="m-nav__item">
    <a href="javascript:" class="m-nav__link" data-toggle="tooltip" title="My Profile">
      <span class="m-nav__link-text">My Profile</span>
    </a>
  </li>
@endsection

@section('content')
  <profile inline-template>
    <div>
      <portlet-content header="{{ ucwords($user->name) }}" subheader="Profile">
        <template slot="action_button">
          <edit-button title="Edit profile"
                       url="{{ route('admin.users.profile.edit') }}"></edit-button>
        </template>
        <template slot="body">
          @include('admin.modules.users.partials.details')
        </template>
      </portlet-content>
    </div>
  </profile>
@endsection
