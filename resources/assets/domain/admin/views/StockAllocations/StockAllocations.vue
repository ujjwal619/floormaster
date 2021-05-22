<template>
  <div class="form-container">
    <loading :loading="loading" />
    <div class="col-12 row">
      <span class="col-1 text-right h4">Store:</span>
      <drop-down
              class="col-3"
              :options="alteredSites"
              v-model="selectedSite"
              style="max-height: 40px;"
              :default-selected="sites[0]"
      />
    </div>
    <!-- <div class="d-flex justify-content-between">
      <span class="text-warning h3 text-bold">{{ siteName }}</span>
    </div> -->
    <div class="row pt-2">
      <div class="col-12">
        <portlet-content :height="465" :onlybody="true">
          <div slot="body" class="row cheque-table">
            <div class="col-12 px-4">
              <div class="row table-wrap">
                <table class="table">
                  <tbody>
                    <tr class="row col-12">
                      <td class="table-head col-2">Client</td>
                      <td class="table-head col-1">Project</td>
                      <td class="table-head col-1">Job</td>
                      <td class="table-head col-1">&nbsp;</td>
                      <td class="table-head col-1">Size Age</td>
                      <td class="table-head col-2">Product</td>
                      <td class="table-head col-1">Against Item</td>
                      <td class="table-head col-1">Required</td>
                      <td class="table-head col-1">&nbsp;</td>
                      <td class="table-head col-1">Cust.Ord</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row table-wrap" style="max-height: 420px;overflow-y: auto;">
                <table class="table">
                  <tbody>
                    <tr 
                      class="row col-12" 
                      v-for="allocation in allocations" 
                      :key="allocation.id" 
                    >
                      <td @click="dispatchClickHandler(allocation)" class="form-control font-weight-bold col-2">{{ allocation.client }}</td>
                      <td @click="dispatchClickHandler(allocation)" class="form-control col-1">{{ allocation.project }}</td>
                      <td 
                        class="form-control font-weight-bold col-1"
                        @click="redirectToJob(allocation.job_id)"
                      >
                        {{ allocation.job_no }}
                      </td>
                      <td class="form-control col-1">{{ formatViewDate(allocation.created_at) }}</td>
                      <td class="form-control font-weight-bold col-1">{{ allocation.amount }}</td>
                      <td class="form-control font-weight-bold col-2">{{ allocation.product_name + ' ' + allocation.color_name }}</td>
                      <td class="form-control col-1">{{ allocation.current_stock_roll }}</td>
                      <td class="form-control text-danger col-1">{{ formatViewDate(allocation.date_required) }}</td>
                      <td class="form-control col-1">&nbsp;</td>
                      <td class="col-1 d-flex justify-content-center align-items-center" @click.stop>
                        <input type="checkbox" />
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
                    <!-- <button type="button" class="btn action-buttons" @click="openModal('SearchAllocation')">Search</button> -->
                  </div>
                  <span class="background-black text-truncate mr-3 my-1">
                    Stock Allocations
                  </span>
              </div>
          </portlet-content>
      </div>
    </div>
    <edit-stock-allocation
      v-if="mountEditStockAllocation"
      :allocation="selectedAllocation"
      @close="closeModal('EditStockAllocation')"
      @updated="allocationUpdated"
    />
    <search-allocation
      v-if="mountSearchAllocation"
      @selected="siteSelected"
      @close="closeModal('SearchAllocation')"
    />
  </div>
  
</template>

<script>

import PortletContent from '../../../common/components/Portlets/Content/PortletContent';
import EditStockAllocation from './components/EditStockAllocation';
import SearchAllocation from './components/SearchAllocation';
import { getSites, getAllocations } from "../../api/calls";
import { LoadingMixin } from "../../../common/mixins";
import { formatViewDate } from '../../../common/utitlities/helpers';
import DropDown from '../../../common/components/DropDown/DropDown'


export default {
  name: 'StockAllocations',
  mixins: [LoadingMixin],
  components: {
    PortletContent,
    EditStockAllocation,
    SearchAllocation,
    DropDown
  },
  data: () => ({
    mountEditStockAllocation: false,
    mountSearchAllocation: false,
    allocations: [],
    selectedAllocation: {},
    sites: [],
    alteredSites: [
      {
        id: 0,
        name: 'All Stores',
      }
    ],
    selectedSite: '',
  }),
  computed: {
    selectedSiteData() {
      return this.sites.find(site => site.id === this.selectedSite) || {};
    },
    siteName() {
      return this.selectedSiteData.name || 'All Stores';
    },
  },
  created() {
    this.fetchSites();
  },
  watch: {
    selectedSite: {
      deep: true,
      handler(value) {
        this.fetchAllocationsBySite(value);
      }
    }
  },
  methods: {
    formatViewDate,
    redirectToJob(jobId) {
      window.location.href = `/jobs/${jobId}/edit`;
    },
    // fetchMyFirstAllowedSite() {
    //   this.enableLoading();
    //   getMyFirstAllowedSite()
    //     .then(({ data }) => {
    //       this.selectedSite = data.data;
    //       this.disableLoading();
    //     })
    //     .catch(() => {
    //       this.disableLoading();
    //       this.$toastr('error', 'Could not fetch Allocations.');
    //     });
    // },
    fetchSites() {
      this.enableLoading();
      getSites().then(({ data }) => {
        this.sites = data.data;
        this.alteredSites = [...this.alteredSites, ...data.data];
      })
      .catch(err => this.$toastr("error", "Could not get site data.", "Error!!"))
      .finally(this.disableLoading);
    },
    fetchAllocationsBySite(siteId = this.selectedSite) {
      this.enableLoading();
      getAllocations({site: siteId})
        .then(({ data }) => {
          this.allocations = data.data;
        })
        .catch(() => {
          this.$toastr('error', 'Could not fetch Allocations.');
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
      this.fetchAllocationsBySite(this.selectedSite);
    },
    siteSelected(site) {
      this.selectedSite = site;
    },
  }
};
</script>

<style scoped>
.form-control {
  line-height: 24px !important;
}
</style>
