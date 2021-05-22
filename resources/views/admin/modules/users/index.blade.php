@extends('admin.layouts.main')

@section('title', 'Users List')

@section('breadcrumb')
    <li class="m-nav__item">
        <a href="" class="m-nav__link">
            <span class="m-nav__link-text">User List</span>
        </a>
    </li>
@endsection

@section('content')
    <users-list inline-template>
        <div class="users-list">
            <portlet-tabs v-on:tab-changed="handleTabChange">
                <template slot="buttons">
                    <div>
                        <a href="{{ route('admin.users.create') }}">
                        <button
                                class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air"
                                title="Add new user"
                                data-toggle="tooltip"
                        >
                            <i class="fa fa-plus"></i>
                        </button>
                    </a>
                    </div>
                </template>

                <portlet-tab name="branches" title="<i class='fa fa-users'></i> Active Users">
                    <vue-table
                        source="{{ route('admin.users.table', 'active') }}"
                        :columns="['name', 'email', 'username', 'role', 'status', 'action']"
                    ></vue-table>
                </portlet-tab>

                <portlet-tab name="contacts" title="<i class='fa fa-address-book'></i> Inactive Users">
                    <vue-table
                        source="{{ route('admin.users.table', 'inactive') }}"
                        :columns="['name', 'email', 'username', 'role', 'status', 'action']"
                    ></vue-table>
                </portlet-tab>
            </portlet-tabs>
        </div>
    </users-list>
@endsection
