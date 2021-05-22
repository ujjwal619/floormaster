<template>
   <modal :title="modalTitle" @close="handleClose">
     <loading :loading="loading" />
      <template slot="modal-body">
        <div class="row">
          <template v-if="isGeneralCashBook">
            <div class="col-9">
              <div class="row">
                <label class="col-4 text-right"><b> {{ isDebit ? 'Debit' : 'Credit' }} Account:</b></label>
                <label class="col-3 pl-1"><b>{{ chequeAccount.code }}</b></label>
                <label class="col-4"><b>{{ chequeAccount.name }}</b></label>
              </div>
              <div class="row pt-2">
                <label class="col-4 text-right"><b>Payee:</b></label>
                <label class="col-6 pl-1"><b>{{ data.payee }}</b></label>
              </div>
              <div class="row pt-3">
                <label class="col-4 text-right"><b>Date:</b></label>
                <label class="col-6 pl-1"><b>{{ data.date }}</b></label>
              </div>
              <div class="row pt-3">
                  <label class="col-4 text-right"><b>Presented Date:</b></label>
                  <input type="date" v-model="model.presented_date" class="form-control col-6 pl-1" >
                </div>
              <div class="row pt-2">
                <label class="col-4 text-right"><b>Net Amount $:</b></label>
                <label class="col-6 pl-1"><b>{{ data.net_amount }}</b></label>
              </div>
              <div class="row pt-2">
                <label class="col-4 text-right">
                  <b>GST:</b>
                </label>
                <label class="col-6 pl-1"><b>{{ data.gst_credit }}</b></label>
              </div>
              <div class="row pt-2">
                <label class="col-4 text-right"><b>Job:</b></label>
                <drop-down
                  v-model="model.job_id"
                  :options="jobs"
                  :default-selected="selectedJob"
                  class="col-6 pl-1"
                  label="job_id"
                />
              </div>
              <div class="row pt-3">
                <label class="col-4 text-right"><b>{{ isDebit ? 'Debit' : 'Credit' }} Account:</b></label>
                <label class="col-7 pl-1"><b>{{ data.account ? `${data.account.name} : ${data.account.code}` : '' }}</b></label>
              </div>
            </div>
            <div class="col-3">
              <div 
                class="row" 
                v-for="(paymentType, index) in $options.PAYMENTS" 
                :key="paymentType.id"
                :class="{ 'pt-2': index }"
              >
                <label>
                  <input
                    type="radio"
                    v-model="model.payment_type"
                    :value="paymentType.id"
                    name="payment method"
                    v-validate="'required'"
                  />
                  <b>{{ paymentType.label }}</b>
                </label>
                <label class="error">{{ errors.first('payment method') }}</label>
              </div>
            </div>
          </template>
          <template v-else>
            <div class="col-12">
              <div class="row">
                <label class="col-4 text-right"><b> Date: </b></label>
                <label class="col-3 pl-1"><b>{{ data.date }}</b></label>
              </div>
              <div class="row pt-2">
                <label class="col-4 text-right"><b>Payee:</b></label>
                <label class="col-3 pl-1"><b>{{ data.payee }} </b></label>
              </div>
              <div class="row pt-2">
                <label class="col-4 text-right"><b>Amount:</b></label>
                <label class="col-3 pl-1"><b>{{ data.net_amount + data.gst_credit }} </b></label>
              </div>
              <div class="row pt-2" v-if="isDebit">
                <label class="col-4 text-right"><b>Cq/EFT No:</b></label>
                <label class="col-3 pl-1"><b>{{ data.eft_cheque }} </b></label>
              </div>

              <label class="pt-4 text-center"><b v-if="isRemittance">This is an {{ viewPaymentType(data.remittance.payment_type) }} Remittance.</b></label>
              <label class="text-center"><b v-if="isRemittance">It can only be edited via the Cheque Butt.</b></label>
              <label class="pt-4 text-center"><b v-if="isReceipt">This is an Invoice/Bill Receipt.</b></label>
              <label class="text-center"><b v-if="isReceipt">It can only be edited from the Billing screen.</b></label>
              
              <div class="row pt-2">
                <label class="col-4 text-right"><b>{{isDebit ? 'Presented' : 'Banked'}} Date:</b></label>
                <input type="date" v-model="model.presented_date" class="form-control col-6 pl-1" >
              </div>

            </div>
          </template>
        </div>
      </template>
      <template slot="modal-footer">
        <button 
          v-if="isRemittance" 
          type="button" 
          class="btn action-buttons" 
          @click="goToRemittance"
        >Go To Remittance</button>
        <button 
          v-if="isReceipt" 
          type="button" 
          class="btn action-buttons" 
          @click="goToInvoice"
        >Go To Bill</button>
        <button type="button" class="btn action-buttons" @click="nextButtonHandler">Done</button>
        <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
   </modal>
</template>

<script>

const PAYMENTS = [
  { id: "American Express", label: "American Express" },
  { id: "Bank Card", label: "Bank Card" },
  { id: "Barter Card", label: "Barter Card" },
  { id: "Cash", label: "Cash" },
  { id: "Cheque", label: "Cheque" },
  { id: "Diners Club", label: "Diners Club" },
  { id: "Direct Debit", label: "Direct Debit" },
  { id: "EFTPOS", label: "EFTPOS" },
  { id: "Master Card", label: "Master Card" },
  { id: "Money Order", label: "Money Order" },
  { id: "Visa", label: "Visa" },
  { id: "Other", label: "Other" }
];

import PortletContent from '../../../../common/components/Portlets/Content/PortletContent';
import Modal from '../../../../common/components/Modal/Modal';
import DropDown from '../../../../common/components/DropDown/DropDown';
import { LoadingMixin } from '../../../../common/mixins';
import { viewPaymentType } from '../../Remittance/PaymentTypes'
import {
  getJobsBySite,
  putCashBook,
} from '../../../api/calls';

const DEBIT = 1;

export default {
  name: 'EditDebitOrCredit',
  mixins: [LoadingMixin],
  components: {
    PortletContent,
    Modal,
    DropDown,
  },
  props: {
    data: {
      type: Object,
      required: true,
    },
    site: {
      type: Number,
      required: true,
    },
    isDebit: {
      type: Boolean,
    },
  },
  PAYMENTS,
  data: () => ({
    accounts: [],
    jobs: [],
    model: {
      presented_date: '', 
      payment_type: 'EFTPOS',
      job_id: null,
    },
  }),
  computed: {
    chequeAccount() {
      return this.data.site.cheque_account || {};
    },
    type() {
      return this.isDebit ? 1 : 2;
    },
    selectedJob() {
      return this.jobs.find(job => job.id === this.model.job_id) || {};
    },
    isGeneralCashBook() {
      return !(this.isRemittance || this.isReceipt);
    },
    modalTitle() {
      if (this.isGeneralCashBook) {
        return  `Cash Book - Editing ${this.isDebit ? 'Debit' : 'Credit'}`;
      }

      return `Edit Cash Book ${this.isDebit ? 'Debit' : 'Credit'}/s Presented`
    },
    isRemittance() {
      return !!this.data.remit_id;
    },
    isReceipt() {
      return !!this.data.receipt_id;
    },
  },
  created() {
    this.enableLoading();
    this.model.presented_date = this.data.presented_date;
    this.model.payment_type =  this.data.payment_type;
    this.fetchJobs()
      .then(() => this.model.job_id = this.data.job_id)
      .finally(this.disableLoading);
  },
  methods: {
    viewPaymentType,
    goToRemittance() {
      window.location.href = `/cheque-butt?remittance=${this.data.remittance.id}`;
    },
    goToInvoice() {
      window.location.href = `/billings?invoice=${this.data.receipt.invoice_id}`;
    },
    fetchJobs() {
      return getJobsBySite(this.site)
        .then(({ data }) => {
          this.jobs = data.data
        })
        .catch(err => this.$toastr("error", "Could not get jobs data.", "Error!!"))
    },
    handleClose() {
      this.$emit('close');
    },
    emit(event) {
      this.$emit(event);
      this.handleClose();
    },
    nextButtonHandler() {
      this.$validator.validateAll().then(valid => {
        if (valid) {
          this.enableLoading();
          return putCashBook(this.data.id, { ...this.model, type: this.data.type })
            .then(({ data }) => {
              this.$toastr("success", "Updated Cash Book Entry successfully.", "Success!!")
              this.$emit('update');
              this.handleClose();
            })
            .catch(err => this.$toastr("error", "Could not update cashbook data.", "Error!!"))
            .finally(this.disableLoading);
        }
      });
    },
    handleClose() {
      this.$emit("close");
    }
  },

};
</script>
