<template>
  <modal title="Payable Deletion" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <h5><b>THIS PAYABLE WILL BE DELETED</b></h5>
        <p>
          <b>
            If this record was created by marrying the supplier's invoice
            to the order item and if the order still exists in Current
            Orders the value of this payable will be deducted from the 
            'Invoices Received' value in both the order item and the 
            order total.<br>
            A reversal GL transation will also be created.
          </b>
        </p>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="goButtonHandler">Delete</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin } from '../../../../common/mixins'
import { deletePayable } from '../../../api/calls';

export default {
  name: "DeletePayable",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  props: {
    payableId: {
      type: Number,
      required: true,
    }
  },
  data: () => ({
  }),
  methods: {
    goButtonHandler() {
      this.enableLoading();
      deletePayable(this.payableId)
        .then(() => {
          this.$toastr('success', 'Successfully Deleted Payable.', 'Success!!')
          this.$emit('deleted');
          this.handleClose();
        })
        .catch(() => {
          this.$toastr('error', 'Could not delete Payable.', 'Error!!')
        })
        .finally(this.disableLoading);
    },
    handleClose() {
      this.$emit("close");
    }
  }
};
</script>
