@extends('admin.layouts.main')

@section('title', 'Profile')

@section('breadcrumb')
  <li class="m-nav__item">
    <a href="{{ route('admin.users.profile') }}" class="m-nav__link">
      <span class="m-nav__link-text">Profile</span>
    </a>
  </li>
  <li class="m-nav__separator">
    -
  </li>
  <li class="m-nav__item">
    <a href="#" class="m-nav__link">
      <span class="m-nav__link-text">Edit</span>
    </a>
  </li>
@endsection

@section('content')
  {{--send further props from this create user component--}}
  <create-user inline-template url="{{ route('admin.users.profile.update') }}" method="patch"
               user="{{ json_encode($user) }}">
    <portlet-content header="Profile" subheader="Edit" isForm="true">
      <template slot="body">
        <div :class="{'loading': formSubmitting, 'wrapper': formSubmitting}">
          <!--begin::Form-->
          <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                @submit.prevent="submit">
            <div class="m-portlet__body" style="padding: inherit;">
              <div class="form-group m-form__group row">
                <div class="col-lg-6">
                  <label class="required">First Name</label>
                  <input type="text" name="full_name.first_name"
                         :class="{ 'input-error' : form.errors.has('full_name.first_name'), 'form-control': loaded }"
                         placeholder="First Name"
                         v-model="values.full_name.first_name">
                  <span class="m-form__help danger"
                        v-if="form.errors.has('full_name.first_name')"
                        v-text="form.errors.get('full_name.first_name')"></span>
                </div>
                <div class="col-lg-6">
                  <label class="required">Last Name</label>
                  <input type="text" name="full_name.last_name"
                         :class="{ 'input-error' : form.errors.has('full_name.last_name'), 'form-control': loaded }"
                         placeholder="Last Name" v-model="values.full_name.last_name">
                  <span class="m-form__help danger"
                        v-if="form.errors.has('full_name.last_name')"
                        v-text="form.errors.get('full_name.last_name')"></span>
                </div>
              </div>

              <div class="form-group m-form__group row">
                <div class="col-lg-6">
                  <label class="required">Email</label>
                  <input type="text" name="email"
                         :class="{ 'input-error' : form.errors.has('email'), 'form-control': loaded }"
                         disabled
                         placeholder="Email"
                         v-model="values.email">
                  <span class="m-form__help danger"
                        v-if="form.errors.has('email')"
                        v-text="form.errors.get('email')"></span>
                </div>
                <div class="col-lg-6">
                  <label class="required" for="gender">Username</label>
                  <input type="text" name="username"
                         :class="{ 'input-error' : form.errors.has('username'), 'form-control': loaded }"
                         disabled
                         placeholder="Username"
                         v-model="values.username">
                  <span class="m-form__help danger"
                        v-if="form.errors.has('username')"
                        v-text="form.errors.get('username')"></span>
                </div>
              </div>

              <div class="form-group m-form__group row">
                <div class="col-lg-6">
                  <button class="btn btn-primary">Submit</button>
                </div>
              </div>
            </div>
          </form>
          <!--end::Form-->
        </div>

      </template>
    </portlet-content>
  </create-user>
@endsection
