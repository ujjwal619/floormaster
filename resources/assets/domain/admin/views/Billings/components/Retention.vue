<template>
  <modal title="Retention" @close="handleClose">
    <loading :loading="loading" />
    <div slot="modal-body">
      <div class="row">
        <label class="pl-2 col-4 text-right">{{ jobInvoiceNumber }}</label>
      </div>
      <div class="row pt-1">
        <label class="pl-2 col-4 text-right">{{ clientName }}</label>
      </div>
      <div class="row pt-4">
        <label class="col-4 text-right">
          Retention Amount: 
        </label>
        <div class="pl-2 col-6">
          <input type="number" name="retention amount" v-validate="'decimal:2'" v-model="model.retention_amount"/>
          <label class="errors">{{ errors.first('retention amount') }}</label>
        </div>
      </div>
      <div class="row pt-2">
        <label class="col-4 text-right">
          Release Date: 
        </label>
        <div class="pl-2 col-6">
          <input type="date" v-model="model.retention_release_date"/>
        </div>
      </div>
      <div class="row pt-2">
        <label class="pl-2">
          Record and modify retention held against this Invoice here. <br/>
          When Retention is paid reduce this Retention value by that amount, then receipt the 
          payment in the usual fashion.<br/>
          If only part and final payment of Retention has been received then you can use the
          Update...Invoice Expense function to write off the balance.
        </label>
      </div>
    </div>
    <div slot="modal-footer" class="d-flex justify-content-end">
      <button type="button" class="btn action-buttons" @click="saveRetention">Done</button>
      <button type="button" class="btn action-buttons ml-2" @click="handleClose">Cancel</button>
    </div>
  </modal>
  
</template>

<script>

import Modal from '../../../../common/components/Modal/Modal';
import { LoadingMixin } from '../../../../common/mixins/index';

export default {
  name: 'Retention',
  mixins: [LoadingMixin],
  components: {
    Modal,
  },
  props: {
    jobInvoiceNumber: {
      type: String,
      required: true,
    },
    invoice: {
      type: Object,
      required: true,
    },
    clientName: {
      type: String,
      required: true,
    },
  },
  data: () => ({
    model: {}
  }),
  created() {
    this.model.retention_amount = this.invoice.retention_amount;
    this.model.retention_release_date = this.invoice.retention_release_date;
  },
  methods: {
    handleClose() {
      this.$emit('close');
    },
    saveRetention() {
      this.enableLoading();
      axios.put(`api/invoices/${this.invoice.id}/retention`, this.model)
        .then(() => {
          this.$emit('updated');
        })
        .catch(() => {
          console.log('could not update retention');
        })
        .finally(() => {
          this.disableLoading();
          this.handleClose();
        })
    },
  },
};
</script>
