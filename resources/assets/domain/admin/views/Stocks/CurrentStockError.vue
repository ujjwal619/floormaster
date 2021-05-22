<template >
  <modal title="Allocation Alert" @close="closeModal">
    <template slot="modal-body">
      <label>
        4 Sale current stock is empty. <br/>
        Select Another stock.
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
  name: "CurrentStockError",
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
