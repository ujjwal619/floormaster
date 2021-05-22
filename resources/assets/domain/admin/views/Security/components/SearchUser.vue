<template>
  <modal title="Search User" @close="handleClose">
    <template slot="modal-body">
      <div class="form-group m-form__group">
        <div class="col-12">
          <label class="required">Select User:</label>
          <drop-down :options="users" placeholder="Search User" v-model="userId" label="username" />
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button
        type="button"
        class="btn action-buttons"
        :class="{ 'disabled' : stopUserSelect }"
        @click="handleSelect"
        :disabled="stopUserSelect"
      >OK</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";

export default {
  name: "SearchUser",
  components: {
    Modal,
    DropDown
  },
  data: () => ({
    userId: "",
    users: []
  }),
  computed: {
    stopUserSelect() {
      return !this.userId;
    }
  },
  created() {
    axios.get("/api/users").then(({ data }) => {
      this.users = data.data;
    });
  },
  methods: {
    handleClose() {
      this.$emit("close");
    },
    handleSelect() {
      this.$emit("search-and-close", { id: this.userId });
    }
  }
};
</script>
