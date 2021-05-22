<template>
  <modal title="Unlink Back Order" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <label>
          This Back Order is currently allocated to Item No:  {{ backOrder.future_stock.order_number }}
          <br/>
          You can remove this link and the Back Order will become 'Non-Allocated'. <br/>
          It's Allocated value will be removed from Purchase Order item.
        </label>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="unlinkHandler">Unlink</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../common/components/Modal/Modal";
import { LoadingMixin } from '../../../common/mixins'

export default {
  name: "UnlinkBackOrder",
  mixins: [LoadingMixin],
  components: {
    Modal
  },
  props: {
    backOrder: {
      type: Object,
      required: true,
    },
  },
  methods: {
    handleClose() {
      this.$emit("close");
    },
    unlinkHandler() {
      this.enableLoading();
      axios.patch(`/api/back-orders/${this.backOrder.id}/unlink`)
        .then(() => {
          this.$toastr('success', 'Back order unlinked successfully.', 'Success!!')
          window.location.href = `/color/${this.backOrder.variant_id}/stocks`;
        })
        .catch(() => {
          this.$toastr('error', 'Could not unlink back order.', 'Error!!')
        })
        .finally(() => {
          this.handleClose();
          this.disableLoading();
        })
    },
  }
};
</script>
