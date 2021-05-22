<template>
  <modal :title="title" @close="handleClose" class="form-container">
    <loading :loading="loading" />
    <template slot="modal-body">
      <template v-if="!isMit">
        <div class="row pt-1">
          <label class="col-3 text-right">Invoice no:</label>
          <label class="col-8">{{ invoiceNo }}</label>
        </div>
        <div class="row pt-1">
          <label class="col-3 text-right">Client:</label>
          <label class="col-8">{{ clientName }}</label>
        </div>
      </template>
      <div class="row pt-1">
        <label class="col-3 text-right">Date:</label>
        <label class="col-8">{{ formatViewDate(receipt.receipt_date) }}</label>
      </div>
      <div class="row pt-1">
        <label class="col-3 text-right">Amount:</label>
        <label class="col-8">${{ receipt.amount }}</label>
      </div>
      <div class="row pt-1">
        <label class="col-3 text-right">Reference:</label>
        <label class="col-8"></label>
      </div>
      <div class="row pt-1">
        <label class="col-3 text-right">Type:</label>
        <label class="col-8">{{ receipt.payment_method }}</label>
      </div>
      <div class="row pt-3" v-if="isMit">
        <h5>THIS RECEIPT WILL BE DELETED</h5>
        <p class="text-small">
          There is no edit function for money in trust.<br>
          If there is as error in this record then you must
          delete and recreate it.<br>
          When you use the Update function to generate
          an Invoice for this Job FLOORmanager will ask you to
          confirm the allocation of this (and other) MIT
          amounts to that Invoice.<br>
          MIT can also be manually transfered to an existing
          invoice by using the Update ... Allocate MIT function.
        </p>
      </div>
    </template>
    <template slot="modal-footer">
      <button
        v-if="hasPermission('job.access.delete.receipts')" 
        type="button" 
        class="btn action-buttons" 
        @click="deleteReceipt"
      >Delete</button>
      <button type="button" class="btn action-buttons ml-3" @click="handleClose">Cancel</button>
    </template> 
  </modal>
</template>

<script>
import Modal from "./Modal/Modal";
import { formatViewDate } from '../utitlities/helpers';
import { LoadingMixin, CurrentUserMixin } from "../mixins";

export default {
  name: "DeleteReceipt",
  mixins: [LoadingMixin, CurrentUserMixin],
  components: {
    Modal,
  },
  props: {
    receipt: {
      type: Object,
      required: true,
    },
    invoiceNo: {
      type: String,
      default: '',
    },
    clientName: {
      type: String,
      default: '',
    },
  },
  computed: {
    title() {
      return this.isMit ? 'Delete MIT Receipt' : 'Delete Receipt';
    },
    isMit() {
      return !this.receipt.invoice_id;
    },
  },
  methods: {
    formatViewDate,
    deleteReceipt() {
      this.enableLoading();
      axios.delete(`/api/receipts/${this.receipt.id}`)
        .then(() => {
          this.emit('deleted');
          this.$toastr('success', 'Successfully deleted receipt', 'Success!!');
        })
        .catch(() => {
          this.$toastr('error', 'Could not delete receipt', 'Error!!');
        })
        .finally(() => {
          this.disableLoading();
          this.handleClose();
        });
    },
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
