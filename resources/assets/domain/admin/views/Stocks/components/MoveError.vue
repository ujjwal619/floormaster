<template >
  <modal title="Error" @close="closeModal" :has-footer="false">
    <template slot="modal-body">
      <label v-if="module === $options.CURRENT_STOCK">
        Nothing for sale on this item. <br/>
        Select another item.
      </label>
      <label v-else>
        The purchase order item has nothing for sale.
      </label>
      <button type="button" class="btn action-buttons" @click="closeModal">Ok</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";

const CURRENT_STOCK = 'current_stock';
const FUTURE_STOCK = 'future_stock';

export default {
  name: "MoveError",
  components: {
    Modal
  },
  props: {
    module: {
      type: String,
      required: true,
    }
  },
  methods: {
    closeModal() {
      this.$emit("close");
    }
  }
};
</script>
