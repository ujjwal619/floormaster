<template>
  <modal title="FLOORmanager 1.0" @close="handleClose">
    <template slot="modal-body">
      <div class="row form-container">
        {{message}}
      </div>
    </template>
    <template slot="modal-footer">
      <button
        type="button"
        class="btn action-buttons"
        @click="handleClose"
      >OK</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../Modal/Modal";

export default {
  name: "FmError",
  components: {
    Modal,
  },
  props: {
    message: {
      type: String,
      default: 'Error',
    },
  },
  data: () => ({
  }),
  created() {
  },
  methods: {
    handleClose() {
      this.$emit("close");
    },
  }
};
</script>
