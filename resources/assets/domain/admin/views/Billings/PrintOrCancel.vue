<template>
  <modal title="Do you want to Print?" @close="handleClose" class="form-container">
    <template slot="modal-body">
      <div class="row">
         <button type="button" class="btn action-buttons" @click="emit('print')">Print</button>
         <button type="button" class="btn action-buttons ml-3" @click="handleRedirect">Back</button>
      </div>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../common/components/Modal/Modal";

export default {
  name: "TrashOrKeep",
  components: {
    Modal,
  },
  methods: {
    emit(event) {
      this.$emit(event);
    },
    handleClose() {
      this.$emit("close");
    },
    handleRedirect() {
      window.location.href = '/jobs/';
    }
  }
};
</script>
