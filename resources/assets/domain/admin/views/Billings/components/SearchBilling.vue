<template>
  <modal title="Billing Search" @close="handleClose">
    <loading :loading="loading" />
    <div slot="modal-body">
      <div class="row">
        <label class="col-2">
          Shop:
        </label>
        <drop-down :options="sites" class="pl-2 col-10" v-model="siteId" />
      </div>
      <div class="row pt-3">
        <label class="col-2">
          Bill:
        </label>
        <drop-down :options="invoices" class="pl-2 col-10" v-model="invoiceId" label="job_trading_name">
          <template slot="singleLabel" slot-scope="{ data }">{{ data.job_trading_name + ': ' + data.job_project + '. Inv:' + data.job_no + '/' + data.id }}</template>
          <template slot="option" slot-scope="{ data }"><span>{{ data.job_trading_name + ': ' + data.job_project + '. Inv:' + data.job_no + '/' + data.id }}</span></template>
        </drop-down>
      </div>
    </div>
    <div slot="modal-footer" class="d-flex justify-content-end">
      <button type="button" class="btn action-buttons" @click="searchBilling">Search</button>
      <button type="button" class="btn action-buttons ml-2" @click="handleClose">Cancel</button>
    </div>
  </modal>
  
</template>

<script>

import Modal from '../../../../common/components/Modal/Modal';
import DropDown from '../../../../common/components/DropDown/DropDown';
import { LoadingMixin } from '../../../../common/mixins/index';
import { getSites } from "../../../api/calls";

export default {
  name: 'SearchBilling',
  mixins: [LoadingMixin],
  components: {
    Modal,
    DropDown,
  },
  props: {

  },
  data: () => ({
    siteId: {},
    invoiceId: {},
    invoices: [],
    sites: [],
  }),
  watch: {
    siteId(value) {
      this.fetchInvoicesBySite(value);
    },
  },
  created() {
    this.fetchSites();
    this.fetchInvoices();
  },
  methods: {
    fetchSites() {
      this.enableLoading();
      getSites()
        .then(({ data }) => {
          this.sites = data.data;
        })
        .catch(() => {
          this.$toastr('error', 'could not fetch shops.')
        })
        .finally(this.disableLoading);
    },
    fetchInvoices() {
      this.enableLoading();
      axios.get(`/api/invoices/`)
        .then(({ data }) => {
          this.invoices = data.data;
        })
        .catch(() => {
          console.log('could not fetch billings.')
        })
        .finally(this.disableLoading);
    },
    fetchInvoicesBySite(siteId) {
      this.enableLoading();
      axios.get(`/api/sites/${siteId}/invoices`)
        .then(({ data }) => {
          this.invoices = data.data;
        })
        .catch(() => {
          this.$toastr('error', 'could not fetch billings.')
        })
        .finally(this.disableLoading);
    },
    handleClose() {
      this.$emit('close');
    },
    searchBilling() {
      this.$emit('updated', this.invoiceId);
      this.handleClose();
    },
  },
};
</script>
