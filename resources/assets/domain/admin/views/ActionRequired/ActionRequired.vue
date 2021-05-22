<template>
  <div class="form-container">
    <loading :loading="loading" />
    <div class="row">
      <div class="col-12 row">
        <span class="col-lg-1 text-right h4">Store:</span>
        <drop-down
                class="col-3"
                :options="sites"
                v-model="selectedSite"
                style="max-height: 40px;"
                :default-selected="sites[0]"
        />
      </div>
      <div class="col-12 pt-2">
        <portlet-content :height="800" :onlybody="true">
          <div slot="body" class="row cheque-table">
            <div class="col-12 px-4">
              <div class="row table-wrap">
                <table class="table">
                  <tbody>
                    <tr class="row col-12">
                      <td class="table-head " style="width: 100px;">Job</td>
                      <td class="table-head " style="width: 200px;">Client</td>
                      <td class="table-head " style="width: 40px;">Qty</td>
                      <td class="table-head " style="width: 190px;">Supplier</td>
                      <td class="table-head " style="width: 190px;">Range</td>
                      <td class="table-head " style="width: 190px;">Color</td>
                      <td class="table-head " style="width: 20px;">&nbsp;</td>
                      <td class="table-head text-sm-center" style="width: 60px;">On Order</td>
                      <td class="table-head " style="width: 60px;">Alloctd</td>
                      <td class="table-head " style="width: 60px;">Act On</td>
                      <td class="table-head " style="width: 60px;">Dispchd</td>
                      <td class="table-head " style="width: 70px;">&nbsp;</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row table-wrap" style="max-height: 700px;overflow-y: auto;">
                <table class="table">
                  <tbody>
                    <tr class="row col-12"  v-for="(action, index) in actionRequired" :key="index" >
                      <td 
                        class="form-control font-weight-bold " 
                        style="width: 100px;"
                        @click="redirectToJob(action.job_id)"
                      >
                        {{ action.job_no }}
                      </td>
                      <td class="form-control font-weight-bold " style="width: 200px;">{{ action.client_name }}</td>
                      <td class="form-control " style="width: 40px;">{{ action.quantity }}</td>
                      <td class="form-control " style="width: 190px;">{{ action.supplier_name }}</td>
                      <td class="form-control font-weight-bold " style="width: 190px;">{{ action.product_name }}</td>
                      <td class="form-control font-weight-bold " style="width: 190px;">{{ action.variant_name }}</td>
                      <td class="form-control " style="width: 20px;">{{ action.material_from ? action.material_from : 'P' }}</td>
                      <td class="form-control text-danger " style="width: 60px;">{{ action.on_order }}</td>
                      <td class="form-control " style="width: 60px;">{{ displayNumber(action.allocated) }}</td>
                      <td class="form-control " style="width: 60px;">{{ displayNumber(action.actt_on) }}</td>
                      <td class="form-control " style="width: 60px;">{{ displayNumber(action.dispatched) }}</td>
                      <td style="width: 70px;"><button :disabled="!canAct(action)" class="action-buttons btn" @click="openActModal(action)">Act</button></td>
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
                    <!-- <button type="button" class="btn action-buttons" @click="">Report</button> -->
                  </div>
                  <span class="background-black text-truncate mr-3 my-1">
                    Action Required
                  </span>
              </div>
          </portlet-content>
      </div>
    </div>
    <template v-if="mountActOnMaterial">
      <act-on-material
        :material="selectedMaterialForActing"
        @orderfuturestock="orderFutureStockForJob"
        @close="closeModal('ActOnMaterial')"
      />
    </template>
    <template v-if="mountOrderStock">
      <order-stock
        :selected-material-for-acting="selectedMaterialForActing"
        @ordered="futureOrderCompleted"
        @close="closeModal('OrderStock')"
      />
    </template>
  </div>
  
</template>

<script>

import PortletContent from '../../../common/components/Portlets/Content/PortletContent';
import { getSites, getActionRequired } from "../../api/calls";
import { LoadingMixin } from "../../../common/mixins";
import ActOnMaterial from '../Jobs/components/ActOnMaterial';
import OrderStock from './components/OrderStock';
import { displayNumber } from '../../../common/utitlities/helpers'
import DropDown from '../../../common/components/DropDown/DropDown'

export default {
  name: 'ActionRequired',
  mixins: [LoadingMixin],
  components: {
    PortletContent,
    ActOnMaterial,
    OrderStock,
    DropDown
  },
  data: () => ({
    mountEditStockAllocation: false,
    mountSearchAllocation: false,
    mountActOnMaterial: false,
    mountOrderStock: false,
    actionRequired: [],
    selectedAllocation: {},
    selectedSite: '',
    sites: [],
    selectedMaterialForActing: {},
    supplier: {},
    color: {},
    product: {},
    quantity: {},
    listPrice: {},
  }),
  created() {
    this.fetchSites();
  },
  watch: {
    selectedSite: {
      handler(id) {
        this.fetchActionRequired(id);
      }
    }
  },
  computed: {
  },
  methods: {
    displayNumber,
    fetchSites() {
      this.enableLoading();
      getSites().then(({ data }) => {
        this.sites = data.data;
      })
        .catch(err => this.$toastr("error", "Could not get site data.", "Error!!"))
        .finally(this.disableLoading);
    },
    redirectToJob(jobId) {
      window.location.href = `/jobs/${jobId}/edit`;
    },
    canAct(material) {
      if (!material.product_act_on_me) {
        return false;
      }
      return material.actt_on > 0;
    },
    orderFutureStockForJob() {
      this.closeModal('ActOnMaterial');
      this.openModal('OrderStock');
    },
    openActModal(material) {
      this.selectedMaterialForActing = { ...material };
      this.mountActOnMaterial = true;
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
    futureOrderCompleted() {
      console.log('here');
      this.fetchActionRequired();
    },
    fetchActionRequired(siteId = this.selectedSite) {
      this.enableLoading();
      // axios.get(`/api/action-required?site=${siteId}`)
      getActionRequired({site: siteId})
        .then(({ data }) => {
          this.actionRequired = data.data;
        })
        .catch(() => {
          this.$toastr('error', 'Could not fetch Action Required.');
        })
        .finally(this.disableLoading);
    },
    // dispatchClickHandler(allocation) {
    //   this.selectedAllocation = allocation;
    //   this.openModal('EditStockAllocation');
    // },
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
    // allocationUpdated() {
    //   this.fetchActionRequired();
    // },
    // siteSelected(site) {
    //   this.selectedSite = site;
    // },
  }
};
</script>

<style scoped>
.form-control {
  line-height: 24px !important;
}
</style>
