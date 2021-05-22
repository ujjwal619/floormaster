<template>
  <modal title="Add User ID" @close="handleClose">
    <template slot="modal-body">
      <div class="form-group m-form__group">
        <div class="col-12 mt-3">
          <label class="required">User ID:</label>
          <input class="form-control" type="text" v-model="model.username" />
          <span class="form-error" v-text="form.errors.get('username')"></span>
        </div>
        <div class="col-12 mt-3">
          <label class="required">Password:</label>
          <input class="form-control" type="password" v-model="model.password" />
          <span class="form-error" v-text="form.errors.get('password')"></span>
        </div>
        <div class="col-12 mt-3">
          <label class="required">Confirm Password:</label>
          <input class="form-control" type="password" v-model="model.confirm_password" />
          <span
            class="form-error"
            v-if="passwordsDontMatch"
          >Password and confirm password dont match</span>
        </div>
        <div class="col-12 mt-3">
          <label class="required">Select Shops:</label>
          <drop-down
            :options="sites"
            placeholder="Select Sites"
            v-model="model.sites"
            :multiple="true"
            :close-on-select="false"
          />
          <span class="form-error" v-text="form.errors.get('sites')"></span>
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button
        type="button"
        class="btn action-buttons"
        :class="{ 'disabled' : stopUserSave }"
        @click="handleSave"
        :disabled="stopUserSave"
      >OK</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import Form from "../../../../common/utitlities/Form";
import DropDown from "../../../../common/components/DropDown/DropDown";

export default {
  name: "AddUser",
  components: {
    Modal,
    DropDown
  },
  data: () => ({
    model: {
      username: "",
      password: "",
      confirm_password: "",
      sites: []
    },
    passwordsDontMatch: false,
    form: new Form()
  }),
  props: {
    sites: {
      type: Array,
      default: []
    }
  },
  computed: {
    stopUserSave() {
      return !(this.model.username && this.model.password);
    }
  },
  methods: {
    handleClose() {
      this.$emit("close");
    },
    handleSave() {
      if (this.model.password !== this.model.confirm_password) {
        this.passwordsDontMatch = true;
        return;
      }
      this.form = new Form(this.model);
      const method = "post";
      const url = `/api/users`;

      axios
        .post(url, this.model)
        .then(({ data }) => {
          this.$emit("created", data.data.id);
          this.$toastr("success", "Successfully created new User", "Success!!");
        })
        .catch(error => {
          this.$emit("close");
          this.$toastr("error", `Could not create new User`, "Error!!");
        });
    }
  }
};
</script>
