<template>
  <modal title="Add Payable" @close="handleClose">
    <loading :loading="loading" />
    <div slot="modal-body" class="px-2">
      <template v-if="page ===1">
        <div class="row">
          <label class="col-3 text-right">Store:</label>
          <drop-down
            class="col-8 ml-2"
            :options="sites"
            placeholder="Select Store"
            v-model="siteId"
          />
        </div>
        <div class="row pt-3">
          <label class="col-3 text-right">Supplier:</label>
          <drop-down
            class="col-8 ml-2"
            :options="suppliers"
            label="trading_name"
            placeholder="Select Supplier"
            v-model="selectedSupplier"
          />
        </div>
        <div class="row pt-3">
          <label class="col-3 text-right">Liability Account:</label>
          <drop-down
            class="col-8 ml-2"
            :options="accounts"
            placeholder="Select Liability Account"
            v-model="model.liability_account"
            :default-selected="defaultLiabilityAccount"
          />
        </div>
        <div class="row pt-3">
          <label class="col-3 text-right">Cost Account:</label>
          <drop-down
            class="col-8 ml-2"
            :options="accounts"
            placeholder="Select Cost Account"
            v-model="model.cost_account"
            :default-selected="defaultCostAccount"
          />
        </div>
        <div class="row pt-3">
          <label class="col-3 text-right">Levy Account:</label>
          <drop-down
            class="col-8 ml-2"
            :options="accounts"
            placeholder="Select Levy Account"
            v-model="model.levy_account"
            :default-selected="defaultLevyAccount"
          />
        </div>
        <div class="row pt-4">
          <label class="col-3 text-right">Our Order No:</label>
          <input type="number" class="col-4 form-control ml-2" v-model="model.order_no" />
        </div>
        <div class="row pt-2">
          <label class="col-3 text-right">Supplier's Reference:</label>
          <input type="text" class="col-4 form-control ml-2" v-model="model.supplier_reference" />
        </div>
        <div class="row pt-2">
          <label class="col-3 text-right">Invoice Amount $:</label>
          <input type="number" class="col-4 form-control ml-2" v-model="model.invoice_amount" name="invamt" v-validate="'required'" />
          <label class="col-10 text-right error">{{ errors.first('invamt') }}</label>
        </div>
        <div class="row pt-2">
          <label class="col-3 text-right">Invoice Date:</label>
          <input 
            type="date" 
            class="col-4 form-control ml-2" 
            v-model="model.invoice_date" 
            name="invoice date" 
            v-validate="{ required: true, date_between: dateRangeForValidation }"
          />
          <label
              class="error"
              v-if="errors.firstByRule('invoice date', 'required')"
          >The invoice date field is required.</label>
          <label
            class="error"
            v-if="errors.firstByRule('invoice date', 'date_format')"
          >The invoice date field is required.</label>
          <label
            class="error"
            v-if="errors.firstByRule('invoice date', 'date_between')"
          >The invoice date field must be between {{ startDate }} and {{ endDate }}.</label>
        </div>
        <div class="row pt-3">
          <label class="col-3 text-right">Goods $:</label>
          <input type="number" class="col-4 form-control ml-2" v-model="model.goods" />
        </div>
        <div class="row pt-2">
          <label class="col-3 text-right">Freight $:</label>
          <input type="number" class="col-4 form-control ml-2" v-model="model.freight" />
        </div>
        <div class="row pt-2">
          <label class="col-3 text-right">Levy $:</label>
          <input type="number" class="col-4 form-control ml-2" v-model="model.levy" />
        </div>
        <div class="row pt-2">
          <label class="col-3 text-right">GST $:</label>
          <input type="number" class="col-4 form-control ml-2" v-model="model.gst" />
        </div>
        <div class="row pt-2">
          <label class="col-3" >&nbsp;</label>
          <label class="col-4 ml-2">GST on COS/Expenses</label>
        </div>
        <div class="row pt-3">
          <label class="col-3 text-right">Comments:</label>
          <input type="text" class="col-8 form-control ml-2" v-model="model.comments" />
        </div>
        <div class="row pt-3">
          <label class="col-3 text-right">Job:</label>
          <drop-down
            class="col-8 ml-2"
            :options="jobs"
            placeholder="Select job"
            label="job_id"
            v-model="model.job_id"
          />
        </div>
        <div class="row pt-3 d-flex align-items-center">
          <label class="col-2">&nbsp;</label>
          <input type="checkbox" />
          <label class="col-6 ml-1">Warn me if GST does not equal 10%</label>
        </div>
        <div class="row pt-2 d-flex align-items-center">
          <label class="col-2">&nbsp;</label>
          <input type="checkbox" />
          <label class="col-6 ml-1">Check for Invoice Duplication%</label>
        </div>
      </template>
      <template v-else>
        <label>
          The Invoice Amount exceeds the calculated amount by $2423.00<br/>
          Floor manager will make an Adjustment of -$2423.00
        </label>
        <label class="mt-4">
          Please briefly explain this adjustment (50 characters max). <br/>
          Your explanation will appear on the remittance.
        </label>
        <div class="row pt-3">
          <label class="col-3 text-right">Explain:</label>
          <input type="text" class="col-8 form-control" />
        </div>
      </template>
    </div>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" v-if="page === 1">&lt; Back</button>
      <button type="button" class="btn action-buttons" @click="savePayable" >Next ></button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin, CurrentUserMixin } from '../../../../common/mixins'
import {
  getSites,
  getSuppliersBySite,
  getAccountsBySite,
  getJobsBySite
} from "../../../api/calls";
import {
  getFiscalYear,
  getFiscalYearDateRangeForValidation,
  getCurrentMonth,
  getMonthRangeForValidation,
  formatViewDate,
  formatDate
} from "../../../../common/utitlities/helpers";

export default {
  name: "AddPayables",
  mixins: [LoadingMixin, CurrentUserMixin],
  components: {
    DropDown,
    Modal
  },
  data: () => ({
    model: {},
    suppliers: [],
    selectedSupplier: '',
    page: 1,
    sites: [],
    liabilityAccounts: [],
    accounts: [],
    jobs: [],
    siteId: '',
    defaultLiabilityAccount: '',
    defaultCostAccount: '',
    defaultLevyAccount: '',
    selectedSite:  {},
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
  },
  watch: {
    siteId(value) {
      this.selectedSite = this.sites.find(site => site.id === value) || {};
      this.fetchSuppliersBySite(value);
      this.fetchLiabilityAccountBySite(value);
      this.fetchAccountsBySite(value);
      this.fetchJobsBySite(value);
    },
    selectedSupplier(value) {
      const supplier = this.suppliers.find(supplier => supplier.id === value) || {};
      this.defaultCostAccount = this.findAccountById(supplier.default_cost_account);
      this.defaultLevyAccount = this.findAccountById(supplier.levy_account);
    },
  },
  created() {
    this.fetchSites();
  },
  methods: {
    validate() {
      return this.$validator.validate();
    },
    savePayable() {
      this.$validator.validateAll()
        .then(valid => {
          if (valid) {
            this.enableLoading();
            axios.post(`/api/suppliers/${this.selectedSupplier}/payables`, this.model)
              .then(({ data }) => {
                this.$emit('updated', data.data.id);
                this.$toastr('success', 'Successfully created payables.', 'Success!!')
              })
              .catch(() => {
                this.$toastr('error', 'Could not create payables.', 'Error!!')
              })
              .finally(() => {
                this.handleClose();
                this.disableLoading();
              })
          }
        });
    },
    fetchLiabilityAccountBySite(siteId) {
      axios.get(`/accounts/2/sites/${siteId}`)
        .then(({ data }) => {
          this.liabilityAccounts = data.data;
        })
        .catch(() => {
          console.log('could not fetch liability account.');
        })
    },
    fetchAccountsBySite(siteId) {
      getAccountsBySite(siteId)
        .then(({ data }) => {
          this.accounts = data.data;
          this.defaultLiabilityAccount = data.data.find(account => account.id === this.selectedSite.trade_creditors_id) || '';
        })
        .catch(() => {
          console.log('could not fetch accounts.');
        })
    },
    findAccountById(id) {
      return this.accounts.find(account => account.id === id) || {};
    },
    fetchJobsBySite(siteId) {
      getJobsBySite(siteId)
        .then(({ data }) => {
          this.jobs = data.data;
        })
        .catch(() => {
          console.log('could not fetch jobs.');
        })
    },
    fetchSuppliersBySite(siteId) {
      this.enableLoading();
      getSuppliersBySite(siteId)
        .then(({ data }) => {
          this.suppliers = data.data;
        })
        .catch(() => {
          console.log('could not fetch suppliers.');
        })
        .finally(this.disableLoading)
    },
    fetchSites() {
      this.enableLoading();
      getSites()
        .then(({ data }) => {
          this.sites = data.data
        })
        .catch(() => {
          console.log('could not fetch sites')
        })
        .finally(this.disableLoading);
    },
    handleClose() {
      this.$emit("close");
    }
  }
};
</script>
