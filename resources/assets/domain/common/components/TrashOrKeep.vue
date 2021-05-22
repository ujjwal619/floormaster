<template>
  <modal title="Trash Or Keep it" @close="handleClose" class="form-container">
    <template slot="modal-body">
      <div class="row">
         <button type="button" class="btn action-buttons" @click="emit('trash-it')">Trash It</button>
         <button type="button" class="btn action-buttons ml-3" @click="handleClose">Keep It </button>
      </div>
    </template>
  </modal>
</template>

<script>
import Modal from "./Modal/Modal";

export default {
  name: "TrashOrKeep",
  components: {
    Modal,
  },
  methods: {
    handleClose() {
      this.$emit("close");
    },
    emit(event) {
      this.$emit(event);
      this.handleClose();
    }
  }
};
</script>
