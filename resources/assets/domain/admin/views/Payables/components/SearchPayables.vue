<template>
  <modal title="Search" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <label>Store:</label>
        <drop-down
          ref="searchStore"
          :options="sites"
          placeholder="Store"
          v-model="selectedSite"
        />
      </div>
      <div class="row pt-3">
        <label>Supplier: </label>
        <drop-down
          ref="searchSupplier"
          placeholder="Supplier"
          v-model="selectedSupplier"
          :options="suppliers"
        />
      </div>
      <div class="row pt-3">
        <label>Customer: </label>
        <drop-down
          ref="searchCustomer"
          placeholder="Customer"
          v-model="selectedCustomer"
          label="trading_name"
          :options="customers"
        />
      </div>
      <div class="row pt-3">
        <label>Job No.: </label>
        <drop-down
          ref="searchJob"
          placeholder="Job No."
          v-model="selectedJob"
          :options="jobs"
          label="job_id"
        />
      </div>
      <div class="row pt-3">
        <label>Invoice No: </label>
        <drop-down
          ref="selectOrder"
          placeholder="Invoice No"
          v-model="payableId"
          :options="payables"
          label="supplier_reference"
          v-validate="'required'"
          name="payables"
        >
          <template slot="singleLabel" slot-scope="{ data }">{{ (data.supplier_reference || '') + ' ' + data.supplier_trading_name + ' $' + data.expected_amount + ' O/N ' + data.order_no + ' Job: ' + data.job_no + ' SN: ' + data.id }}</template>
          <template slot="option" slot-scope="{ data }"><span>{{ (data.supplier_reference || '') + ' ' + data.supplier_trading_name + ' $' + data.expected_amount + ' O/N ' + data.order_no + ' Job: ' + data.job_no + ' SN: ' + data.id }}</span></template>
        </drop-down>
        <label class="error">{{ errors.first('payables') }}</label>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="goButtonHandler">Go</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { 
  getSites,
  getPayables,
  getSuppliers,
  getJobs,
  getClients,
} from '../../../api/calls'
import { LoadingMixin } from '../../../../common/mixins'

export default {
  name: "SearchPayables",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  data: () => ({
    selectedSite: '',
    selectedSupplier: '',
    selectedCustomer: '',
    selectedJob: '',
    payableId: '',
    sites: [],
    suppliers: [],
    customers: [],
    jobs: [],
    payables: [],
    searchParams: {},
  }),
  watch: {
    selectedSite(value) {
      if (value) {
        this.selectedSupplier = '';
        this.selectedCustomer = '';
        this.selectedJob = ''
        this.payableId = '';
        this.$refs.searchSupplier.reset();
        this.$refs.searchCustomer.reset();
        this.$refs.searchJob.reset();
        this.$refs.selectOrder.reset();
        this.searchParams = { 'site_id': value};
        this.fetchSuppliers();
        this.fetchClients();
        this.fetchJobs();
        this.fetchPayables();
      }
    },
    selectedSupplier(value) {
      if (value) {
        this.selectedCustomer = '';
        this.selectedJob = ''
        this.payableId = '';
        this.$refs.searchCustomer.reset();
        this.$refs.searchJob.reset();
        this.$refs.selectOrder.reset();
        this.searchParams = { ...this.searchParams, 'supplier_id': value};
        this.fetchClients();
        this.fetchJobs();
        this.fetchPayables();
      }
    },
    selectedCustomer(value) {
      if (value) {
        this.selectedJob = ''
        this.payableId = '';
        this.$refs.searchJob.reset();
        this.$refs.selectOrder.reset();
        this.searchParams = { ...this.searchParams, 'customer_id': value};
        this.fetchJobs();
        this.fetchPayables();
      }
    },
    selectedJob(value) {
      if (value) {
        this.payableId = '';
        this.$refs.selectOrder.reset();
        this.searchParams = { ...this.searchParams, 'job_id': value};
        this.fetchPayables();
      }
    },
  },
  created() {
    this.fetchPayables();
    this.fetchSites();
    this.fetchSuppliers();
    this.fetchJobs();
    this.fetchClients();
  },
  methods: {
    fetchSites() {
      this.enableLoading();
      getSites()
        .then(({ data }) => {
          this.sites = data.data;
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },
    fetchPayablesBySite(siteId) {
      this.enableLoading();
      axios
        .get(`/api/sites/${siteId}/payables`)
        .then(({ data }) => (this.payables = data.data))
        .catch(error =>
          this.$toastr("error", "Error fetching data", "Error!!")
        )
        .finally(() => this.disableLoading());
    },
    fetchPayables() {
      this.enableLoading();
      getPayables(this.searchParams)
        .then(({ data }) => {
          this.payables = data.data;
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },
    fetchSuppliers() {
      this.enableLoading();
      getSuppliers(this.searchParams)
        .then(({ data }) => {
          this.suppliers = data.data;
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },
    fetchJobs() {
      this.enableLoading();
      getJobs(this.searchParams)
        .then(({ data }) => {
          this.jobs = data.data;
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },
    fetchClients() {
      this.enableLoading();
      getClients(this.searchParams)
        .then(({ data }) => {
          this.customers = data.data;
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },  
    goButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          this.$emit('selected', this.payableId);
          this.handleClose();
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
