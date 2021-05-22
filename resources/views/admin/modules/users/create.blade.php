@extends('admin.layouts.main')

@section('title', 'Users List')

@section('breadcrumb')
    <li class="m-nav__item">
        <a href="{{ route('admin.users.index') }}" class="m-nav__link">
            <span class="m-nav__link-text">Users</span>
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
    {{--send further props from this create user component--}}
    <create-user inline-template url="{{ route('admin.users.store') }}">
        <portlet-content header="Users" subheader="Create" isForm="true">
            <template slot="body">
                @include('admin.modules.users.partials.form', ['action' => 'create'])
            </template>
        </portlet-content>
    </create-user>
@endsection
