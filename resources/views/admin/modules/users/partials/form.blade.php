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
          <span class="form-error"
                v-if="form.errors.has('full_name.first_name')"
                v-text="form.errors.get('full_name.first_name')"></span>
        </div>
        <div class="col-lg-6">
          <label class="required">Last Name</label>
          <input type="text" name="full_name.last_name"
                 :class="{ 'input-error' : form.errors.has('full_name.last_name'), 'form-control': loaded }"
                 placeholder="Last Name" v-model="values.full_name.last_name">
          <span class="form-error"
                v-if="form.errors.has('full_name.last_name')"
                v-text="form.errors.get('full_name.last_name')"></span>
        </div>
      </div>

      <div class="form-group m-form__group row">
        <div class="col-lg-6">
          <label class="required">Email</label>
          <input type="text" name="email"
                 :class="{ 'input-error' : form.errors.has('email'), 'form-control': loaded }"
                 {{ $action == 'edit' ? 'disabled' : '' }}
                 placeholder="Email"
                 v-model="values.email">
          <span class="form-error"
                v-if="form.errors.has('email')"
                v-text="form.errors.get('email')"></span>
        </div>
        <div class="col-lg-6">
          <label class="required" for="gender">Username</label>
          <input type="text" name="username"
                 :class="{ 'input-error' : form.errors.has('username'), 'form-control': loaded }"
                 {{ $action == 'edit' ? 'disabled' : '' }}
                 placeholder="Username"
                 v-model="values.username">
          <span class="form-error"
                v-if="form.errors.has('username')"
                v-text="form.errors.get('username')"></span>
        </div>
      </div>

      <div class="form-group m-form__group row">
        <div class="col-lg-6">
          <label class="required">Role</label>
          <select name="role" v-model="values.role"
                  :class="{ 'input-error' : form.errors.has('role'), 'form-control': loaded }">
            <option value="">Select Role</option>
            @foreach($roles as $id => $role)
              <option value="{{ $id }}">{{ deSlugify($role) }}</option>
            @endforeach
          </select>

          <span class="form-error"
                v-if="form.errors.has('role')"
                v-text="form.errors.get('role')"></span>
        </div>
        @if($action=='create')
          <div class="col-lg-6">
            <label class="required">Password</label>
            <input type="text" name="password"
                   :class="{ 'input-error' : form.errors.has('password'), 'form-control': loaded }"
                   placeholder="Password"
                   v-model="values.password">
            <span class="m-form__help danger"
                  v-if="form.errors.has('password')"
                  v-text="form.errors.get('password')"></span>
          </div>
        @endif
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
