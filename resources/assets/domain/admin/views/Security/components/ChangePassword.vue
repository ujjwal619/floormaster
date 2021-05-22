<template>
  <modal title="Change Password" @close="handleClose">
    <template slot="modal-body">
      <div class="form-group m-form__group">
        <div class="col-12 mt-3">
          <label class="required">New Password:</label>
          <input class="form-control" type="password" v-model="model.password" />
          <span class="form-error" v-text="form.errors.get('password')"></span>
        </div>
        <div class="col-12 mt-3">
          <label class="required">Confirm New Password:</label>
          <input class="form-control" type="password" v-model="model.confirm_password" />
          <span class="form-error" v-text="form.errors.get('confirm_password')"></span>
        </div>
        <div class="col-12 mt-1" v-if="showError">
          <label class="text-danger">Passwords do not Match</label>
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button
        type="button"
        class="btn action-buttons"
        :class="{ 'disabled' : stopPasswordChange }"
        @click="saveHandler"
        :disabled="stopPasswordChange"
      >OK</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import Form from "../../../../common/utitlities/Form";

export default {
  name: "ChangePassword",
  components: {
    Modal
  },
  data: () => ({
    model: {
      password: "",
      confirm_password: ""
    },
    showError: false,
    form: new Form()
  }),
  props: {
    user: {
      type: Object,
      required: true
    },
  },
  computed: {
    stopPasswordChange() {
      return !(this.model.confirm_password && this.model.password);
    },
    passwordMatcher() {
      return this.model.confirm_password === this.model.password;
    }
  },
  watch: {
    model(value) {
      if (!value.password || !value.confirm_password) {
        this.showError = false;
      }
    }
  },
  methods: {
    handleClose() {
      this.$emit("close");
    },
    saveHandler() {
      if (this.passwordMatcher) {
        this.handleSave();
      } else {
        this.showError = true;
      }
    },
    handleSave() {
      this.form = new Form(this.model);
      const method = "put";
      const url = `/api/users/${this.user.id}`;

      axios.put(url, this.model)
        .then(() => {
          this.$toastr(
            "success",
            "Successfully updated New Password",
            "Success!!"
          );
        })
        .catch(() => {
          this.$toastr(
            "error",
            `Could not update New Password, ${this.form.alertMessage}`,
            "Error!!"
          );
        })
        .finally(() => this.$emit('close'))
      //
      // this.form
      //   .onSubmit(method, url)
      //   .then(data => {
      //     this.$toastr(
      //       "success",
      //       "Successfully updated New Password",
      //       "Success!!"
      //     );
      //   })
      //   .catch(error => {
      //     this.$toastr(
      //       "error",
      //       `Could not update New Password, ${this.form.alertMessage}`,
      //       "Error!!"
      //     );
      //   });
    }
  }
};
</script>
