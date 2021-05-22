<template>
  <modal title="Allocate Money Held In Trust" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <label>Select Invoice:</label>
        <drop-down
          :options="invoices"
          placeholder="Select Invoice"
          v-model="selectedInvoice"
          v-validate="'required'"
          name="invoice"
        >
          <template slot="singleLabel" slot-scope="{ data }">{{ data.job_no + '/' + data.id + ' : ' + data.date + ' : $' + data.amount }}</template>
          <template slot="option" slot-scope="{ data }"><span>{{ data.job_no + '/' + data.id + ' : ' + data.date + ' : $' + data.amount }}</span></template>
        </drop-down>
        <label class="error">{{ errors.first('invoice') }}</label>
      </div>
      <div class="row pt-3">
        <label>Select M.I.T. Payment/s</label>
        <drop-down
          placeholder="Search MIT Pyment/s"
          v-model="selectedPayments"
          :options="mitPayments"
          v-validate="'required'"
          :multiple="true"
          :show-multiple-label="false"
          name="MIT Payments"
        >
          <template slot="selection" slot-scope="{ data }">
            <span class="multiselect__single" v-if="data.values.length &amp;&amp; !data.isOpen">{{ data.values.length }} payments selected</span>
          </template>
          <template slot="option" slot-scope="{ data }"><span>{{ data.payment_method + ' Payment of ' + data.receipt_date + ', Ref: for $' + data.amount }}</span></template>
        </drop-down>
        <label class="error">{{ errors.first('MIT Payments') }}</label>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="goButtonHandler">Next ></button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin } from '../../../../common/mixins'
import { getSites, getNonAllocatedReceipts } from '../../../api/calls'
import Axios from 'axios';

export default {
  name: "AllocateMIT",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  props: {
    job: {
      type: Object,
      required: true
    },
    nonAllocatedMit: {
      type: Array,
      default: [],
    },
  },
  data: () => ({
    selectedInvoice: "",
    selectedPayments: [],
    invoices: [],
    mitPayments: [],
  }),
  created() {
    this.fetchInvoices();
    this.fetchMitPayments();
  },
  methods: {
    fetchInvoices() {
      this.enableLoading();
      axios.get(`/api/invoices?job_id=${this.job.id}`)
        .then(({ data }) => {
          this.invoices = data.data || [];
        })
        .catch(() => {
          console.log('could not fetch invoices.')
        })
        .finally(this.disableLoading);
    },
    fetchMitPayments() {
      this.enableLoading();
      getNonAllocatedReceipts(this.job.id, {date_range_filter: true})
        .then(({ data }) => {
          this.mitPayments = data.data;
        })
        .catch(() => {
          console.log('could not fetch payments.')
        })
        .finally(this.disableLoading);
    },
    goButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          axios
           .post(`/api/jobs/${this.job.id}/invoice/${this.selectedInvoice}/allocate-mit`, { mit_payments: this.selectedPayments })
           .then(() => {
             this.$emit('updated');
           })
           .catch(() => {
             this.$toastr('error', 'Could not allocate mit.', 'Error!!');
           })
           .finally(() => {
             this.disableLoading();
             this.handleClose();
           })
        }
      });
    },
    validate() {
      return this.$validator.validate();
    },
    handleClose() {
      this.$emit("close");
    }
  }
};
</script>
