@extends('admin.layouts.main')

@section('title', 'Users List')

@section('breadcrumb')
    <li class="m-nav__item">
        <a href="{{ route('admin.roles.index') }}" class="m-nav__link">
            <span class="m-nav__link-text">Roles</span>
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
    <portlet-content header="Role" subheader="Create" isForm="true">
        <template slot="body">
            <div>
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="POST"
                      action="{{ route('admin.roles.store') }}">
                    @csrf
                    @include('admin.modules.roles.partials.form')
                </form>
            </div>
        </template>
    </portlet-content>
@endsection
