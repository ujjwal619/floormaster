@extends('admin.layouts.main')

@section('title', 'Roles List')

@section('breadcrumb')
    <li class="m-nav__item">
        <a href="" class="m-nav__link">
            <span class="m-nav__link-text">Roles</span>
        </a>
    </li>
@endsection

@section('content')
    <portlet-content header="Roles" subheader="list">
        <template slot="action_button">
            <a href="{{ route('admin.roles.create') }}">
                <button
                        class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air"
                        title="Add new role"
                        data-toggle="tooltip"
                >
                    <i class="fa fa-plus"></i>
                </button>
            </a>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-md-12">
                    <vue-table
                            source="{{ route('admin.roles.table') }}"
                            :columns="['name', 'title', 'action']"
                    ></vue-table>
                </div>
            </div>
        </template>
    </portlet-content>
@endsection
