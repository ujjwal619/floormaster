<template>
   <modal :title="`${isDebit ? 'Debit' : 'Credit'}/s Presented`" @close="handleClose" :is-large="true">
     <loading :loading="loading" />
      <template slot="modal-body">
        <div class="row">
          <div class="col-8">
            <div class="row">
              <label class="col-4 text-right"><b>Date {{ isDebit ? 'Drawn' : 'Recvd' }}:</b></label>
              <label class="col-4"><b>{{ formatViewDate(data.date) }}</b></label>
            </div>
            <div class="row pt-2" v-if="isDebit">
              <label class="col-4 text-right" v-if="!isRemittance"><b>{{ isEFT ? 'EFT' : 'Cheque' }} No:</b></label>
              <label class="col-4 text-right" v-else><b>Direct Debit</b></label>
              <label class="col-4"><b>{{data.eft_cheque}}</b></label>
            </div>
            <div class="row pt-2" v-else>
              <label class="col-4 text-right"><b>Type</b></label>
              <label class="col-4"><b>{{data.payment_type}}</b></label>
            </div>
            <div class="row pt-2">
              <label class="col-4 text-right"><b>Payee:</b></label>
              <label class="col-4"><b>{{data.payee}}</b></label>
            </div>
            <div class="row pt-2">
              <label class="col-4 text-right"><b>Amount:</b></label>
              <label class="col-4"><b>${{data.net_amount + data.gst_credit}}</b></label>
            </div>
            <div class="row pt-3">
              <label class="col-4 text-right"><b>Presented Date:</b></label>
              <input type="date" v-model="model.presented_date" v-validate="'required'" name="presented date" class="form-control col-6 pl-1" >
              <label class="error">{{ errors.first('presented date') }}</label>
            </div>

            <template>
              <div class="row pt-3">
                <label class="col-12" v-if="isDebit"><b>Select other {{ isEFT ? 'EFT' : 'Cheque' }} payments presented on this day...</b></label>
                <label class="col-12" v-else><b>Select other receipts banked on this day...</b></label>
              </div>
              <div class="row">
                <drop-down 
                  placeholder="Select other payments"
                  :options="cashBooksWithOptionName" 
                  class="pl-2 col-10" 
                  v-model="cashBookIds"
                  :multiple="true"
                  :show-multiple-label="true"
                  label="optionName"
                />
              </div>
            </template>
          </div>

          <div class="col-4">
            <b>This process marks debits as presented. Enter or confirm the Presented Date.
            This list at left contains all unpresented {{ isDebit ? 'payments' : 'receipts'}}. If there are other {{ isDebit ? 'payments' : 'receipts'}} 1
            listed that were presented on that date you can selected them all. Floormanager
            will mark all your selections as presented on that date. <br>
            To undo presentation, click on the item in the Cash Book.</b>
          </div>
        </div>
      </template>
      <template slot="modal-footer">
        <button type="button" class="btn action-buttons" @click="nextButtonHandler">Next ></button>
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
import { formatViewDate } from '../../../../common/utitlities/helpers';
import {
  getJobsBySite,
  bulkUpdateCashBook,
} from '../../../api/calls';

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
    cashBooks: {
      type: Array,
      required: true,
    },
  },
  PAYMENTS,
  data: () => ({
    accounts: [],
    jobs: [],
    cashBookIds: [],
    model: {
      presented_date: '', 
      payment_type: 'EFTPOS',
      job_id: null,
    },
  }),
  computed: {
    cashBooksWithOptionName() {
      return this.cashBooks.map(cashBook => ({
        ...cashBook,
        optionName: `${this.getChequeNumber(cashBook)}, $${(cashBook.net_amount + cashBook.gst_credit)}, ${cashBook.payee}, ${this.formatViewDate(cashBook.date)}`
      }));
    },
    remittance() {
      if (this.data.remit_item_id) {
        return this.data.remit_item.remittance || {};
      }

      return {};
    },
    isRemittance() {
      return !!this.remittance.payment_type;
    },
    isEFT() {
      return this.remittance.payment_type === 1;
    },
    type() {
      return this.isDebit ? 1 : 2;
    },
    selectedJob() {
      return this.jobs.find(job => job.id === this.model.job_id) || {};
    },
    chequeNumber() {
      this.getChequeNumber(this.data);
    },
  },
  created() {
    this.model.presented_date = this.data.presented_date;
  },
  methods: {
    formatViewDate,
    getChequeNumber(data) {
      if (data.remit_item_id) {
        const remittance = data.remit_item.remittance || {};
        return remittance.payment_type === 1 ? 'E' + remittance.id : remittance.cheque_number;
      }
      return '';
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
          this.cashBookIds.push(this.data.id);
          const payload = this.cashBookIds.map(cashBookId => {
            return {
              id: cashBookId,
              presented_date: this.model.presented_date
            };
          })
          return bulkUpdateCashBook({ cash_books: payload})
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
