<template>
  <modal :title="getTitle" @close="handleClose">
    <template slot="modal-body">
      <loading :loading="loading" />
      <div class="col-12" v-show="!isInvoiceDifferent">
        <div class="row">
          <label class="col-3 text-right">Existing Invoices:</label>
          <drop-down class="col-7" :options="changedInvoiceList" v-model="model.related_invoice" label="invoiceName">
          </drop-down>
        </div>
        <div class="row pt-3">
          <label class="col-3 text-right">Job:</label>
          <label class="col-7">{{ job.job_id }}</label>
        </div>
        <div class="row pt-2">
          <label class="col-3 text-right">Name:</label>
          <label class="col-7">{{ job.trading_name }}</label>
        </div>
        <div class="row pt-2">
          <label class="col-3 text-right">Project:</label>
          <label
            class="col-7"
          >{{ job.project }} {{ companyDeliveryAddress.street }}, {{ companyDeliveryAddress.town }}, {{ companyDeliveryAddress.state }} {{ companyDeliveryAddress.code }}</label>
        </div>
        <div class="row pt-3">
          <div class="col-1">&nbsp;</div>
          <span class="h6 text-bolder my-auto col-10">
            Job {{ job.job_id }} is {{ job.completed_percent }}% completed.<br>
            The net quote amount is ${{ netQuotePrice }}.<br>
            ${{ alreadyInvoiced }} has already been invoiced.<br>
            {{ invoicedNetQuotePricePercent }}% of the net quote price has been Invoiced.
          </span>
        </div>
        <div class="row pt-3">
          <label class="col-3 text-right">Net Amt:</label>
          <input class="col-7 form-control" type="number" v-model="model.amount">
        </div>
        <div class="row pt-2">
          <label class="col-3 text-right">Date:</label>
          <input 
            class="col-7 form-control" 
            type="date" 
            v-model="model.date" 
            name="date" 
            v-validate="{ required: true, date_between: dateRangeForValidation }"
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
        <div class="row pt-3">
          <div class="col-1">&nbsp;</div>
          <span class="h6 text-bolder my-auto col-10">
            To view an existing Invoice/Credit of this Job, select it from the list
            then activate the 'View Selected Invoice' button.
            <br>If this process was activated from the Billing screen you may 'Grab'
            the text from the current Invoice/Credit (under this dialog) to use in
            the new Invoice/Credit you are now creating.
            <br>To issue a Credit simply enter a negative Invoice Amount
          </span>
        </div>
        <div class="row pt-4">
          <div class="col-2 d-flex align-items-center justify-content-end">
            <input type="checkbox" v-model="model.isPrompt" id="isPrompt">
          </div>
          <label class="col-8" for="isPrompt">Prompt me if invoice total &lt;&gt; quote price</label>
        </div>
      </div>
      <div class="col-10 mx-auto" v-show="isInvoiceDifferent">
        <span class="row h6 text-bolder">
          <h5>WARNING!</h5>Your Total Invoice Amount differs from your Quote Price.
          <br>The Net Quote Amount is ${{ netQuotePrice }}.
          <br>${{ expectedNetInvoice }} will become the Total Net Invoiced
        </span>
        <div class="row pt-4">
          <div class="col-2 d-flex align-items-center justify-content-end">
            <input type="checkbox" id="remind_me">
          </div>
          <label class="col-8" for="remind_me">Don't remind me again</label>
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button
        v-if="isInvoiceDifferent"
        type="button"
        class="btn action-buttons"
        @click="backHandler"
      >&lt; Back</button>
      <button type="button" class="btn action-buttons" @click="nextHandler" :disabled="loading">Next &gt;</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import axios from "axios";
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin, CurrentUserMixin } from "../../../../common/mixins";
import {
  getFiscalYear,
  getFiscalYearDateRangeForValidation,
  getCurrentMonth,
  getMonthRangeForValidation,
  formatViewDate,
  formatDate
} from "../../../../common/utitlities/helpers";
import moment from 'moment';

export default {
  name: "CreateInvoice",
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
    netQuotePrice: {
      type: Number|String,
      default: 0,
    },
    totalBilledInvoice: {
      type: Number|String,
      default: 0,
    },
    gst: {
      type: Number,
      default: 0,
    }
  },
  data: () => ({
    model: {
      isPrompt: false,
      related_invoice: "",
      amount: "",
      date: formatDate(new Date()),
    },
    isInvoiceDifferent: false,
  }),
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
    changedInvoiceList() {
      if (!this.invoices.length) {
        return [];
      }
      return this.invoices.map(invoice => ({ 
        ...invoice, 
        invoiceName: `${this.job.job_id}/${invoice.id} : ${invoice.date} : $${invoice.amount}, $${invoice.amount} Due.` 
        })
      );
    },
    expectedNetInvoice() {
      const price = (100 * this.model.amount) / (100 + this.gst);
      const total = price + Number(this.alreadyInvoiced);
      return total.toFixed(2);
    },
    alreadyInvoiced() {
      const price = (100 * this.totalBilledInvoice) / (100 + this.gst);
      return price.toFixed(2);
    },
    getTitle() {
      return this.isInvoiceDifferent
        ? "Invoice Alert"
        : "Create New Invoice/ Credit for this Job";
    },
    customer() {
      return this.job.customer || {};
    },
    companyDeliveryAddress() {
      return this.customer.delivery_address || {};
    },
    invoicedNetQuotePricePercent() {
      const value = 100 * (Number(this.alreadyInvoiced) / this.netQuotePrice);
      return value.toFixed(2);
    },
  },
  created() {
    this.model.amount = this.netQuotePrice;
  },
  methods: {
    handleClose() {
      this.$emit("close", true);
    },
    emit(event) {
      this.$emit(event);
      this.$emit("close");
    },
    nextHandler() {
      if (this.model.isPrompt) {
        this.isInvoiceDifferent = !!this.isAmountMoreThanQuotedPrice();
        this.model.isPrompt = false;
      } else {
        this.createInvoiceHandler();
      }
    },
    isAmountMoreThanQuotedPrice() {
      const price = (100 * this.model.amount) / (100 + this.gst);
      return this.alreadyInvoiced >= price;
    },
    backHandler() {
      this.isInvoiceDifferent = false;
    },
    validate() {
      return this.$validator.validate();
    },
    createInvoiceHandler() {
      this.validate().then(valid => {
        if (valid) {
          this.createInvoice();
        }
      });
    },
    createInvoice() {
      const url = `/jobs/${this.job.id}/invoice`;

      this.enableLoading();
      axios.post(url, this.model)
        .then(({ data }) => {
          window.location.href = `/jobs/${this.job.id}/invoice/${data.data.id}/print`;
          this.$toastr(
            "success",
            "Successfully created new invoice!",
            "Success!!"
          );
        })
        .catch(() => {
          this.$toastr("error", "Could not create new invoice", "Error!!");
        })
        .finally(() => {
          this.disableLoading();
        });
    }
  }
};
</script>
