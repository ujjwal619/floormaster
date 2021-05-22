<template>
  <modal title="Delete Allocation" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <label>
          <b>{{ allocation.client }}</b>
          <br/>
          <br/>
          <b>{{ allocation.amount }}</b>
          <br/>
          <br/>
          <b>THIS ALLOCATION WILL BE DELETED.</b>
          <br/>
        </label>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="deleteAllocation">Delete It</button>
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
    deleteAllocation() {
      this.enableLoading();
      axios.delete(`/api/allocations/${this.allocation.id}`)
        .then(() => {
          this.$toastr('success', 'Allocation deleted successfully.', 'Success!!')
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
