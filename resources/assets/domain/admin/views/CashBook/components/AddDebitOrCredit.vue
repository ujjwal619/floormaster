<template>
   <modal :title="`Cash Book - Adding ${isDebit ? 'Debit' : 'Credit'}`" @close="handleClose">
     <loading :loading="loading" />
      <template slot="modal-body">
        <div class="row">
          <div class="col-9">
            <div class="row">
              <label class="col-4 text-right"> {{ isDebit ? 'Debit' : 'Credit' }} Account:</label>
              <label class="col-3 pl-1"><b>{{ chequeAccount.code }}</b></label>
              <label class="col-4"><b>{{ chequeAccount.name }}</b></label>
            </div>
            <div class="row pt-2">
              <label class="col-4 text-right">Payee:</label>
              <div class="col-7 pl-1">
                <drop-down
                v-model="model.payee"
                :options="suppliers"
                label="trading_name"
                :return-object="true"
                name=payee
              />
                <!-- <input type="text" v-model="model.payee" name="payee" v-validate="'required'" class="form-control" > -->
                <label class="error">{{ errors.first('payee') }}</label>
              </div>
            </div>
            <div class="row pt-3">
              <label class="col-4 text-right">Date:</label>
              <div class="col-6 pl-1">
                <input 
                  type="date"
                  v-model="model.date" 
                  name="date" 
                  v-validate="{ required: true, date_between: dateRangeForValidation }" 
                  class="form-control"
                >
                <label
                  class="error"
                  v-if="errors.firstByRule('date', 'required')"
                >The date field is required.</label>
                <label
                  class="error"
                  v-if="errors.firstByRule('date', 'date_format')"
                >The date field is required.</label>
                <label
                  class="error"
                  v-if="errors.firstByRule('date', 'date_between')"
                >The date field must be between {{ startDate }} and {{ endDate }}.</label>
              </div>
            </div>
            <div class="row pt-2">
              <label class="col-4 text-right">Net Amount $:</label>
             <div class="col-6 pl-1">
                <input type="number" v-model="model.net_amount" name="net amount" v-validate="'required|decimal:2'" class="form-control" >
                <label class="error">{{ errors.first('net amount') }}</label>
              </div>
            </div>
            <div class="row pt-2">
              <label class="col-4 text-right">
                GST
                <template v-if="isDebit"> Credit </template>
                <template v-else> Debit </template> 
                $:
              </label>
              <div class="col-6 pl-1">
                <input type="number" v-model="model.gst_credit" name="gst" v-validate="'decimal:2'" class="form-control" >
                <label class="error">{{ errors.first('gst') }}</label>
              </div>
            </div>
            <div class="row pt-2">
              <label class="col-4 text-right">Job No:</label>
              <drop-down
                v-model="model.job_id"
                :options="jobs"
                class="col-6 pl-1"
                label="job_id"
              />
            </div>
            <div class="row pt-3">
              <label v-if="isDebit" class="col-4 text-right">Select Debit Account:</label>
              <label v-else class="col-4 text-right">Select Credit Account:</label>
              <drop-down
                v-model="model.account_id"
                :options="accounts"
                class="col-7 pl-1"
              />
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
                {{ paymentType.label }}
              </label>
              <label class="error">{{ errors.first('payment method') }}</label>
            </div>
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
import { LoadingMixin, CurrentUserMixin } from '../../../../common/mixins';
import {
  getAccountsBySite,
  getSuppliersBySite,
  getJobsBySite,
  postCashBook,
  getSiteById
} from '../../../api/calls';
import {
  getFiscalYear,
  getFiscalYearDateRangeForValidation,
  getCurrentMonth,
  getMonthRangeForValidation,
  formatViewDate,
  displayMoney
} from "../../../../common/utitlities/helpers";
import { format } from 'date-fns';

export default {
  name: 'AddDebitOrCredit',
  mixins: [LoadingMixin, CurrentUserMixin],
  components: {
    PortletContent,
    Modal,
    DropDown,
  },
  props: {
    isDebit: {
      type: Boolean,
    },
    site: {
      type: Number,
      required: true,
    },
  },
  PAYMENTS,
  data: () => ({
    accounts: [],
    suppliers: [],
    jobs: [],
    siteData: {},
    model: {
      payee: '',
      date: format(new Date(), 'yyyy-MM-dd'),
      net_amount: null,
      gst_credit: null,
      payment_type: 'EFTPOS',
      job_id: null,
      account_id: null,
    },
  }),
  computed: {
    type() {
      return this.isDebit ? 1 : 2;
    },
    chequeAccount() {
      return this.siteData.cheque_account || {};
    },
    startDate() {
      const startDate = this.isSuperAdmin ? getFiscalYear() : getCurrentMonth();
      return formatViewDate(startDate);
    },
    endDate() {
      const endDate = this.isSuperAdmin ? getFiscalYear('end') : getCurrentMonth('end');
      return formatViewDate(endDate);
    },
    dateRangeForValidation() {
      return this.isSuperAdmin ? getFiscalYearDateRangeForValidation() : getMonthRangeForValidation();
    },
  },
  created() {
    this.enableLoading();
    Promise.all([
      this.fetchAccounts(), 
      this.fetchJobs(),
      this.fetchSite(),
      this.fetchSuppliers(),
    ])
      .then(this.disableLoading);
  },
  methods: {
    displayMoney,
    fetchAccounts() {
      return getAccountsBySite(this.site)
        .then(({ data }) => {
          this.accounts = data.data
        })
        .catch(err => this.$toastr("error", "Could not get accounts data.", "Error!!"))
    },
    fetchSuppliers() {
      return getSuppliersBySite(this.site)
        .then(({ data }) => {
          this.suppliers = data.data
        })
        .catch(err => this.$toastr("error", "Could not get suppliers data.", "Error!!"))
    },
    fetchSite() {
      return getSiteById(this.site)
          .then(({ data }) => {
            this.siteData = data.data
          })
      .catch(err => this.$toastr("error", "Could not get site data.", "Error!!"))
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
          return postCashBook(this.getPayload())
            .then(({ data }) => {
              this.$toastr("success", "Added Cash Book Entry successfully.", "Success!!")
              this.$emit('add');
              this.handleClose();
            })
            .catch(err => this.$toastr("error", "Could not save cashbook data.", "Error!!"))
            .finally(this.disableLoading);
        }
      });
    },
    getPayload() {
      this.model.supplier_id = this.model.payee.id;
      this.model.payee = this.model.payee.trading_name;
      return { ...this.model, site_id: this.site, type: this.type };
    },
    handleClose() {
      this.$emit("close");
    }
  },

};
</script>
