<template>
  <div class="form-container">
    <loading :loading="loading" />
    <div class="d-flex justify-content-between">
      <span class="text-warning h3 text-bold">{{ `${selectedShop.name || ''} (${selectedSite.name})` }}</span>
    </div>
    <div class="row pt-2">
      <div class="col-12">
        <portlet-content :height="655" :onlybody="true">
          <div slot="body" class="row cheque-table">
            <div class="col-12 px-4">
              <div class="row table-wrap">
                <table class="table">
                  <tbody>
                    <tr class="row col-12">
                      <td class="table-head" style="width: 5%">Job No</td>
                      <td class="table-head" style="width: 10%">Client</td>
                      <td class="table-head" style="width: 10%">Project</td>
                      <td class="table-head" style="width: 7%">Primary Rep</td>
                      <td class="table-head" style="width: 4%">Order</td>
                      <td class="table-head" style="width: 8%">Initiated</td>
                      <td class="table-head" style="width: 4%">&nbsp;</td>
                      <td class="table-head" style="width: 8%">Completion</td>
                      <td class="table-head" style="width: 8%">Measured</td>
                      <td class="table-head" style="width: 6%">Quoted</td>
                      <td class="table-head" style="width: 6%">Invoiced</td>
                      <td class="table-head" style="width: 7%">Bal Due</td>
                      <td class="table-head  text-center" style="width: 15%">D&nbsp;&nbsp;  I&nbsp;&nbsp;  B&nbsp;&nbsp;  C&nbsp;&nbsp;  M&nbsp;&nbsp;  P&nbsp;&nbsp;  X&nbsp;&nbsp; </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row table-wrap" style="max-height: 600px; overflow-y: auto;scrollbar-width: none; ">
                <table class="table">
                  <tbody>
                    <tr class="row col-12"  v-for="wip in wips" :key="wip.id">
                      <td class="form-control font-weight-bold" style="width: 5%" @click="redirectToJob(wip.id)">{{ wip.job_id || '&nbsp;' }} </td>
                      <td class="form-control" style="width: 10%">{{ wip.trading_name }}</td>
                      <td class="form-control font-weight-bold" style="width: 10%">{{ wip.project }}</td>
                      <td class="form-control" style="width: 7%">{{ wip.primary_sales_rep }}</td>
                      <td class="form-control" style="width: 4%">{{ wip.order_status }}</td>
                      <td class="form-control" style="width: 8%">{{ formatViewDate(wip.initiation_date) }}</td>
                      <td class="form-control font-weight-bold" style="width: 4%">{{ wip.completed_percent ? wip.completed_percent + '%' : '' }}</td>
                      <td class="form-control font-weight-bold" style="width: 8%">{{ formatViewDate(wip.complition_date) }}</td>
                      <td class="form-control font-weight-bold" style="width: 8%">{{ formatViewDate(wip.measured_date) }}</td>
                      <td class="form-control text-right" style="width: 6%">{{ wip.quoted }}</td>
                      <td class="form-control text-danger text-right" style="width: 6%">{{ wip.invoiced }}</td>
                      <td class="form-control text-right" style="width: 7%">{{ wip.balance }}</td>
                      <td class="d-flex justify-content-center align-items-center" style="width: 15%" @click.stop>
                        <input type="radio" style="position: relative;" disabled />
                        <input type="radio" disabled />
                        <input type="radio" disabled />
                        <input type="radio" disabled />
                        <input type="radio" disabled />
                        <input type="radio" disabled />
                        <input type="radio" disabled />
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </portlet-content>
      </div>
    </div>
    <div class="row pt-2">
      <div class="col-12 mt-2">
          <portlet-content isform="true" :onlybody="true">
              <div slot="body" class="menu-bar d-flex justify-content-between">
                  <div class="mt-1">
                    <button type="button" class="btn action-buttons" @click="openModal('SearchWip')">Search</button>
                  </div>
                  <span class="background-black text-truncate mr-3 my-1">
                    Work In Progress
                  </span>
              </div>
          </portlet-content>
      </div>
    </div>
    <search-wip
      v-if="mountSearchWip"
      @selected="siteSelected"
      @close="closeModal('SearchWip')"
    />
  </div>
  
</template>

<script>

import PortletContent from '../../../common/components/Portlets/Content/PortletContent';
import SearchWip from './components/SearchWip';
import { getMyFirstAllowedSite } from "../../api/calls";
import { LoadingMixin } from "../../../common/mixins";
import { formatViewDate, alteredTableData } from '../../../common/utitlities/helpers';

export default {
  name: 'WorkInProgress',
  mixins: [LoadingMixin],
  components: {
    PortletContent,
    SearchWip,
  },
  data: () => ({
    mountEditStockAllocation: false,
    mountSearchWip: false,
    wips: [],
    selectedAllocation: {},
    selectedSite: {},
    selectedShop: {},
  }),
  created() {
    this.fetchMyFirstAllowedSite();
  },
  methods: {
    formatViewDate,
    redirectToJob(jobId) {
      window.location.href = `/jobs/${jobId}/edit`
    },
    fetchMyFirstAllowedSite() {
      this.enableLoading();
      getMyFirstAllowedSite()
        .then(({ data }) => {
          this.selectedSite = data.data;
          this.fetchWorkInProgress(this.selectedSite.id);
          this.disableLoading();
        })
        .catch(() => {
          this.disableLoading();
          this.$toastr('error', 'Could not fetch work in progresses.');
        });
    },
    fetchWorkInProgress(siteId, shopId = 0) {
      this.enableLoading();
      axios.get(`/api/work-in-progress?site=${siteId}&shop=${shopId}`)
        .then(({ data }) => {
          this.wips =  alteredTableData(data.data, 25);
        })
        .catch(() => {
          this.$toastr('error', 'Could not fetch work in progresses.');
        })
        .finally(this.disableLoading);
    },
    dispatchClickHandler(allocation) {
      this.selectedAllocation = allocation;
      this.openModal('EditStockAllocation');
    },
    closeModal(type) {
      if(type) {
        this[`mount${type}`] = false;
      }
    },
    openModal(type) {
      if(type) {
        this[`mount${type}`] = true;
      }
    },
    allocationUpdated() {
      this.fetchAllocationsBySite(this.selectedSite.id);
    },
    siteSelected({site, shop}) {
      this.selectedSite = site;
      this.selectedShop = shop;
      this.fetchWorkInProgress(site.id, shop.id)
    },
  }
};
</script>

<style scoped>
.form-control {
  line-height: 24px !important;
}

</style>
