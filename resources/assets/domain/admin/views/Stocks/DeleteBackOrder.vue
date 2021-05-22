<template>
  <modal title="Delete Back Order" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <label>
          <b>{{ backOrder.client }}</b>
          <br/>
          <b>Re:</b>
          <br/>
          <b>{{ backOrder.amount }}</b>
          <br/>
          <br/>
          <b>THIS BACK ORDER WILL BE DELETED.</b>
        </label>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="deleteBackOrder">Delete It</button>
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
    deleteBackOrder() {
      this.enableLoading();
      axios.delete(`/api/back-orders/${this.backOrder.id}`)
        .then(() => {
          this.$toastr('success', 'Back order deleted successfully.', 'Success!!')
          window.location.href = `/color/${this.backOrder.variant_id}/stocks`;
        })
        .catch(() => {
          this.$toastr('error', 'Could not delete back order.', 'Error!!')
        })
        .finally(() => {
          this.handleClose();
          this.disableLoading();
        })
    },
  }
};
</script>
