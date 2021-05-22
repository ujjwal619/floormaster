<template>
  <modal :title="getTitle" @close="handleClose" :is-large="currentPage === 2 ? true: false">
    <template slot="modal-body">
      <loading :loading="loading" />
      <div class="col-12" v-show="currentPage === 1">
        <div class="row">
          <label class="col-12">Select the invoice that this payment is against:</label>
          <drop-down class="col-12" :options="invoices" v-model="model.invoice_id">
            <template slot="singleLabel" slot-scope="{ data }">{{ `${job.job_id}/${data.id}` }}</template>
            <template slot="option" slot-scope="{ data }">
              <span>{{ `${job.job_id}/${data.id} : ${data.date} : $${data.amount}, $${data.balance_due} Due.` }}</span>
            </template>
          </drop-down>
        </div>
      </div>
      <div class="row" v-show="currentPage === 2">
        <div class="col-6">
          <div class="row col-12">
            <label class="col-3">{{ job.job_id }}</label>
            <label class="col-8">{{ job.title + ' ' + job.firstname + ' ' + job.trading_name }}</label>
          </div>
          <div class="row col-12 pt-2">
            <label class="col-3">
              <template v-if="model.invoice_id">
                {{ job.job_id }}/
                {{ model.invoice_id }}
              </template>
              <template v-else>
                Client Deposit
              </template>
            </label>
            <label class="col-8">
              <template v-if="model.invoice_id">
                : {{ `${formatViewDate(selectedInvoice.date)} : $${selectedInvoice.amount.toFixed(2)}, $${invoiceBalanceDue} Due.` }}
              </template>
              <template v-else>
                - No Invoice Selected
              </template>
            </label>
          </div>
          <div class="row col-12 pt-2">
            <label class="col-3 text-right">Receipt Date:</label>
            <div class="col-8">
              <input
                type="date"
                class="form-control"
                v-model="model.receipt_date"
                name="receipt date"
                v-validate="{ required: true, date_between: dateRangeForValidation }"
              />
              <label
                class="error"
                v-if="errors.firstByRule('receipt date', 'required')"
              >The date field is required.</label>
              <label
                class="error"
                v-if="errors.firstByRule('receipt date', 'date_format')"
              >The date field is required.</label>
              <label
                class="error"
                v-if="errors.firstByRule('receipt date', 'date_between')"
              >The date field must be between {{ startDate }} and {{ endDate }}.</label>
            </div>
          </div>
          <div class="row col-12 pt-2">
            <label class="col-3 text-right">Amount:</label>
            <input
              type="number"
              class="col-8 form-control"
              v-model="model.amount"
              name="amount"
              v-validate="'required'"
            />
            <label class="error">{{ errors.first('amount') }}</label>
          </div>
          <div class="row col-12 pt-2">
            <label class="col-3 text-right">Notation:</label>
            <input type="text" class="col-8 form-control" v-model="model.notation" />
          </div>
          <div class="row col-12 pt-4 d-flex align-items-center">
            <label class="col-8">
              <input type="checkbox" />
              Print job Receipt
            </label>
          </div>
        </div>
        <div class="col-6 my-auto">
          <div class="row">
            <label class="col-6" v-for="paymentType in $options.PAYMENTS" :key="paymentType.id">
              <input
                type="radio"
                :value="paymentType.id"
                v-model="model.payment_method"
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
      <button type="button" class="btn action-buttons" @click="nextHandler" :disabled="loading">Next &gt;</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import axios from "axios";
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import Form from "../../../../common/utitlities/Form";
import { 
  formatViewDate,
  getFiscalYear,
  getFiscalYearDateRangeForValidation,
  getCurrentMonth,
  getMonthRangeForValidation,
  formatDate
} from "../../../../common/utitlities/helpers";
import { LoadingMixin, CurrentUserMixin } from "../../../../common/mixins";

const TITLE = ["Receipts-Select Invoice", "Job/Invoice Receipt"];
const PAYMENTS = [
  { id: "American Express", label: "American Express" },
  { id: "Direct Debit", label: "Direct Debit" },
  { id: "Bank Card", label: "Bank Card" },
  { id: "EFTPOS", label: "EFTPOS" },
  { id: "Barter Card", label: "Barter Card" },
  { id: "Master Card", label: "Master Card" },
  { id: "Cash", label: "Cash" },
  { id: "Money Order", label: "Money Order" },
  { id: "Cheque", label: "Cheque" },
  { id: "Visa", label: "Visa" },
  { id: "Diners Club", label: "Diners Club" },
  { id: "Other", label: "Other" }
];

export default {
  name: "CreateReceipt",
  mixins: [LoadingMixin, CurrentUserMixin],
  components: {
    Modal,
    DropDown
  },
  props: {
    job: {
      type: Object,
      required: true
    },
    invoices: {
      type: Array,
      default: () => []
    },
    page: {
      type: Number,
      default: 1
    },
    selectedInvoiceId: {
      type: Number,
      default: 0
    }
  },
  PAYMENTS,
  data: () => ({
    model: {
      invoice_id: "",
      receipt_date: formatDate(new Date()),
      amount: null,
      notation: "",
      payment_method: null
    },
    form: new Form(),
    currentPage: 1
  }),
  watch: {
    page: {
      immediate: true,
      handler(page) {
        this.currentPage = page;
      }
    },
    selectedInvoiceId: {
      immediate: true,
      handler(invoiceId) {
        if (invoiceId > 0) {
          this.model.invoice_id = invoiceId;
        }
      }
    },
  },
  computed: {
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
    selectedInvoice() {
      return this.invoices.find(invoice => invoice.id === this.model.invoice_id) || {};
    },
    invoiceBalanceDue() {
      const { amount, receipts, expenses, retention_amount } = this.selectedInvoice;
      const receiptAmt = this.receiptsSumAmount(receipts);
      const invBalance = Number(amount) - receiptAmt;
      const expenseAmt = this.expensesSumAmount(expenses);
      const netBalance = Number(invBalance) - Number(expenseAmt);
      const afterRetention = Number(netBalance) - Number(retention_amount);
      return Number(afterRetention).toFixed(2);
    },
    getTitle() {
      return TITLE[this.currentPage] || TITLE[0];
    }
  },
  created() {
    if (this.invoices.length <= 0) {
      this.currentPage = 2;
    } else if (this.invoices.length === 1) {
      this.model.invoice_id = this.invoices[0].id;
      this.currentPage = 2;
    }
  },
  methods: {
    formatViewDate,
    handleClose() {
      this.$emit("close", true);
    },
    receiptsSumAmount(receipts) {
      return receipts.reduce((acc, receipt) => Number(receipt.amount) + Number(acc), 0);
    },
    expensesSumAmount(expenses) {
      return expenses.reduce((acc, expense) => Number(expense.net_amount) + Number(acc), 0);
    },
    validate() {
      return this.$validator.validate();
    },
    emit(event) {
      this.$emit(event);
      this.$emit("close");
    },
    nextHandler() {
      if (this.currentPage === 1) {
        this.currentPage = 2;
      } else {
        this.validate().then(valid => {
          if (valid) {
            this.saveReceipt();
          }
        });
      }
    },
    saveReceipt() {
      this.enableLoading();
      this.form = new Form(this.model);
      const method = "post";
      const url = `/jobs/${this.job.id}/receipts`;
      this.form
        .onSubmit(method, url)
        .then(() => {
          this.$toastr("success", this.form.alertMessage, "Success!!");
          this.emit("saved");
        })
        .catch(error => {
          this.$toastr("error", this.form.alertMessage, "Error!!");
        })
        .finally(this.disableLoading);
    }
  }
};
</script>

