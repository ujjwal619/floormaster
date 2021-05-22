@extends('admin.layouts.main')

@section('title', 'Users Details')

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
        <a href="{{ route('admin.users.show', $user->id) }}" class="m-nav__link">
            <span class="m-nav__link-text">{{ $user->formatted_full_name }}</span>
        </a>
    </li>
@endsection

@section('content')
    <user-details inline-template
                  changepasswordurl="{{ route('admin.users.changePasswordAdmin', [$user->id]) }}">
        <div>
            <portlet-content header="User" subheader="Details">
                <template slot="action_button">
                    <delete-button
                        submiturl="{{ route('admin.users.change.status', [$user->id, $buttonDetails['change_action']]) }}"
                        title="{{ $buttonDetails['title'] }}"
                        swaltitle="Are you sure ?"
                        swalsuccesstitle="{{ $buttonDetails['success_message'] }}"
                        itagclassname="{{ $buttonDetails['icon'] }}"
                        method="patch"
                        redirecturl="{{ route('admin.users.show', [$user->id]) }}"
                    ></delete-button>
                    <edit-button
                        url="{{ route('admin.users.edit', $user->id) }}"
                        title="Edit User Details"
                    >
                    </edit-button>
                    <a @click="showModal('changePassword')">
                        <button
                            class="btn btn-outline-warning m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air"
                            title="Change Password"
                            data-toggle="tooltip">
                            <i class="fa fa-lock"></i>
                        </button>
                    </a>
                </template>
                <template slot="body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <tr>
                                    <td><strong> Name </strong></td>
                                    <td> {{ $user->formatted_full_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong> Email </strong></td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong> Username </strong></td>
                                    <td>{{ $user->username ?? "N/A" }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Role</strong></td>
                                    <td>{{ deSlugify($user->roles[0]->name) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>{{ $user->status }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </template>
            </portlet-content>
            @include('admin.modules.users.partials.changePasswordByAdminModal')
        </div>
    </user-details>
@endsection
