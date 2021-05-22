<template>
  <modal title="Record Invoice Expense" @close="handleClose">
    <loading :loading="loading" />
    <div slot="modal-body">
      <div class="row">
        <label class="col-4 text-right">
          Invoice No: 
        </label>
        <label class="pl-2">{{ jobInvoiceNumber }}</label>
      </div>
      <div class="row pt-2">
        <label class="col-4 text-right">
          Name: 
        </label>
        <label class="pl-2">{{ clientName }}</label>
      </div>
      <div class="row pt-2">
        <label class="col-4 text-right">
          Debit Date: 
        </label>
        <input type="date" class="pl-2 ml-2 col-6" v-model="model.debit_date"/>
      </div>
      <div class="row pt-2">
        <label class="col-4 text-right">
          GL Code: 
        </label>
        <drop-down :options="accounts" class="pl-2 col-6" v-model="model.gl_code">

        </drop-down>
      </div>
      <div class="row pt-2">
        <label class="col-4 text-right">
          Payee: 
        </label>
        <input type="text" class="pl-2 ml-2 col-6" v-model="model.payee"/>
      </div>
      <div class="row pt-2">
        <label class="col-4 text-right">
          Net Amount: 
        </label>
        <div class="pl-2 col-6">
          <input type="number" name="net amount" v-validate="'decimal:2'" v-model="model.net_amount"/>
          <label class="errors">{{ errors.first('net amount') }}</label>
        </div>
      </div>
      <div class="row pt-2">
        <label class="col-4 text-right">
          GST: 
        </label>
        <div class="pl-2 col-6">
          <input type="number" name="gst" v-validate="'decimal:2'" v-model="model.gst"/>
          <label class="errors">{{ errors.first('gst') }}</label>
        </div>
      </div>
      <div class="row pt-2">
        <label class="col-4 text-right">
          Notes: 
        </label>
        <input type="text" class="pl-2 ml-2 col-6" v-model="model.notes"/>
      </div>
    </div>
    <div slot="modal-footer" class="d-flex justify-content-end">
      <button type="button" class="btn action-buttons" @click="createInvoice">Done</button>
      <button type="button" class="btn action-buttons ml-2" @click="handleClose">Cancel</button>
    </div>
  </modal>
  
</template>

<script>

import Modal from '../../../../common/components/Modal/Modal';
import DropDown from '../../../../common/components/DropDown/DropDown';
import { LoadingMixin } from '../../../../common/mixins/index';

export default {
  name: 'InvoiceExpense',
  mixins: [LoadingMixin],
  components: {
    Modal,
    DropDown,
  },
  props: {
    jobInvoiceNumber: {
      type: String,
      required: true,
    },
    invoiceId: {
      type: Number,
      required: true,
    },
    clientName: {
      type: String,
      required: true,
    },
    siteId: {
      type: Number,
      required: true,
    },
  },
  data: () => ({
    model: {},
    accounts: []
  }),
  created() {
    this.enableLoading();
    axios.get(`/api/sites/${this.siteId}/accounts`)
      .then(({ data }) => {
        this.accounts = data.data;
      })
      .catch(() => {
        console.log('could not fetch accounts.')
      })
      .finally(this.disableLoading);
  },
  methods: {
    handleClose() {
      this.$emit('close');
    },
    createInvoice() {
      this.enableLoading();
      axios.post(`/api/invoices/${this.invoiceId}/expenses`, this.model)
        .then(() => {
          this.$toastr('success', 'Successfully created expense.');
          this.$emit('updated');
        })
        .catch(() => {
          this.$toastr('error', 'Could not create expense.');
        })
        .finally(() => {
          this.disableLoading();
          this.handleClose();
        });
    },
  },
};
</script>
