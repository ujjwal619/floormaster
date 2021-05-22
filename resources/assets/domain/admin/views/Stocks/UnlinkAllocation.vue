<template>
  <modal title="Unlink Allocation" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <label>
          This Allocation is currently allocated to Item No:  {{ allocation.current_stock.roll_no }}
          <br/>
          You can remove this link and the Allocation will become 'Non-Allocated'. <br/>
          It's Allocated value will be removed from Current Stock item.
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
  name: "UnlinkAllocation",
  mixins: [LoadingMixin],
  components: {
    Modal
  },
  props: {
    allocation: {
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
      axios.put(`/api/allocations/${this.allocation.id}/unlink`)
        .then(() => {
          this.$toastr('success', 'Allocation unlinked successfully.', 'Success!!')
          window.location.href = `/color/${this.allocation.variant_id}/stocks`;
        })
        .catch(() => {
          this.$toastr('error', 'Could not unlink allocation.', 'Error!!')
        })
        .finally(() => {
          this.handleClose();
          this.disableLoading();
        })
    },
  }
};
</script>
