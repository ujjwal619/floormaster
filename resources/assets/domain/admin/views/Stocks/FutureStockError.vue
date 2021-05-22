<template >
  <modal title="Allocation Alert" @close="closeModal">
    <template slot="modal-body">
      <label>
        There is not enought for sale in this Future Stock. <br/>
        Select Another or Allocate twice.
      </label>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="closeModal">Ok</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../common/components/Modal/Modal";

export default {
  name: "FutureStockError",
  components: {
    Modal
  },
  methods: {
    closeModal() {
      this.$emit("close");
    }
  }
};
</script>
