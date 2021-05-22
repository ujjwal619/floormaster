<template>
  <modal title="Select User Memos" @close="handleClose">
    <loading :loading="loading" />
    <div slot="modal-body" class="px-2">
      <div class="row">
        <label>View Active Memos for...</label>
        <drop-down
          :options="users"
          placeholder="Select User"
          label="username"
          v-model="selectedUserId"
          name="staff id"
          v-validate="'required'"
        />
        <label class="col-10 text-right error">{{ errors.first('staff id') }}</label>
      </div>
    </div>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="setUser">Next ></button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin } from '../../../../common/mixins'
import {
  getUsers, getUsersBySite,
} from "../../../api/calls";

export default {
  name: "SetUser",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  props: {
    siteId: {
      type: Number,
      required: true,
    }
  },
  data: () => ({
    users: [],
    selectedUserId: '',
  }),
  created() {
    this.fetchUsers();
  },
  methods: {
    fetchUsers() {
      this.enableLoading();
      getUsersBySite(this.siteId)
        .then(({ data }) => {
          this.users = data.data;
        })
        .catch(() => {
          console.log('could not fetch users');
        })
        .finally(this.disableLoading);
    },
    validate() {
      return this.$validator.validate();
    },
    setUser() {
      this.validate()
        .then(valid => {
          if (valid) {
            this.$emit('selected', this.selectedUserId);
            this.handleClose();
          }
        });
    },
    handleClose() {
      this.$emit("close");
    }
  }
};
</script>
