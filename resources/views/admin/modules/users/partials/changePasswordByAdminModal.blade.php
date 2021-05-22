<modal title="Change Password" :is-large="false" v-if="modals.changePassword.show"
       @close="hideModal('changePassword')">
  <template slot="modal-body">
    <div class="form-group m-form__group row">
      <div class="col-lg-12">
        <label class="required">
          New Password
        </label>
        <input type="password" name="password"
               :class="{ 'input-error' : form.errors.has('password'), 'form-control': loaded }"
               placeholder="New Password" v-model="modals.changePassword.values.password">
        <span class="m-form__help danger"
              v-if="form.errors.has('password')"
              v-text="form.errors.get('password')"></span>
      </div>
    </div>
    <div class="form-group m-form__group row">
      <div class="col-lg-12">
        <label class="required">
          Confirm Password
        </label>
        <input type="password"
               name="password_confirmation"
               :class="{ 'input-error' : form.errors.has('password_confirmation'), 'form-control': loaded }"
               placeholder="Confirm Password"
               v-model="modals.changePassword.values.password_confirmation">
        <span class="m-form__help danger"
              v-if="form.errors.has('password_confirmation')"
              v-text="form.errors.get('password_confirmation')"></span>
      </div>
    </div>
  </template>
  <template slot="modal-footer">
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-danger m-btn--md"
            @click="hideModal('changePassword')">Cancel
    </button>
    <button type="button"
            class="btn m-btn--pill m-btn--air btn-outline-brand m-btn--md"
            @click="changePassword"
            :disabled="modals.changePassword.disableSave">Change Password
    </button>
  </template>
</modal>
