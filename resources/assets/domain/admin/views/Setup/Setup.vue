<script>
import axios from "axios";
import PortletContent from "../../../common/components/Portlets/Content/PortletContent";
import Modal from "../../../common/components/Modal/Modal";
import DropDown from "../../../common/components/DropDown/DropDown";
import { isEmpty } from "../../../common/utitlities/helpers";
import AddShop from "./components/AddShop";
import AddStore from "./components/AddStore";
import AddJobSource from "./components/AddJobSource";
import SalesStaff from "./components/SalesStaff";
import { LoadingMixin } from '../../../common/mixins'
import { getAccountsBySite, getUsersBySite } from "../../api/calls";
import SelectAccount from "../Contractors/components/SelectAccount";

const BASE_STATE = {
  company_details: {},
  postal_address: {},
  delivery_address: {},
  gst_billed_on_sales: {
    name: '',
    id: '',
    code: '',
  },
  gst_on_creditors: {
    name: '',
    id: '',
    code: '',
  },
  trade_creditors: {
    name: '',
    id: '',
    code: '',
  },
  trade_debtors: {
    name: '',
    id: '',
    code: '',
  },
  money_in_trust: {
    name: '',
    id: '',
    code: '',
  },
  job_retention: {
    name: '',
    id: '',
    code: '',
  },
  cheque_account: {
    name: '',
    id: '',
    code: '',
  },
  delivery_bailing: {
    name: '',
    id: '',
    code: '',
  },
  discounts_received: {
    name: '',
    id: '',
    code: '',
  },
  retained_earnings: {
    name: '',
    id: '',
    code: '',
  },
  current_earnings: {
    name: '',
    id: '',
    code: '',
  },
};

export default {
  name: "Setup",
  mixins: [LoadingMixin],
  components: {
    AddShop,
    AddJobSource,
    DropDown,
    Modal,
    PortletContent,
    SalesStaff,
    SelectAccount,
    AddStore
  },
  data: () => ({
    isEdit: false,
    model: { ...BASE_STATE },
    jobSources: [],
    salesStaffs: [],
    sites: [],
    shops: [],
    users: [],
    selectedSite: "",
    selectedShop: {},
    selectedJobSource: {},
    selectedSalesStaff: {},
    mountAddShop: false,
    mountJobSource: false,
    mountSalesStaff: false,
    mountSelectAccount: false,
    mountAddStore: false,
    accountModalFor: '',
    accounts: [],
    modelCache: {
      company_details: {},
      postal_address: {},
      delivery_address: {}
    }
  }),
  computed: {
    isEditMode() {
      return !!this.isEdit;
    }
  },
  watch: {
    selectedSite: {
      handler(id) {
        this.cancelEditMode();
        this.setSiteDetails(id);
        this.fetchSiteRelatedDetails(id);
      }
    }
  },
  created() {
    this.fetchSites();
  },
  methods: {
    closeSelectAccount() {
      this.mountSelectAccount = false;
    },
    accountSelected({ type, selectedOption }) {
      this.model[type] = selectedOption;
    },
    pickAccount(type) {
      this.fetchAccountBySite(this.selectedSite);
      this.accountModalFor = type;
      this.openSelectAccount();
    },
    openSelectAccount() {
      this.mountSelectAccount = true;
    },
    fetchAccountBySite(siteId) {
      this.enableLoading();
      getAccountsBySite(siteId)
        .then(({ data }) => {
          this.accounts = data.data;
        })
        .catch(() => {
          console.log('could not fetch accounts.')
        })
        .finally(this.disableLoading);
    },
    fetchUsersBySite(siteId) {
      this.enableLoading();
      getUsersBySite(siteId)
      .then(({ data }) => {
        this.users = data.data;
      })
      .catch(() => {
        console.log('could not fetch accounts.')
      })
      .finally(this.disableLoading);
    },
    findSite(id) {
      const site = this.sites.find(site => site.id === id);
      return {...site};
    },
    setSiteDetails(id) {
      const selectedSite = this.findSite(id);
      this.model = selectedSite;
      this.model.company_details = selectedSite.company_details
        ? JSON.parse(selectedSite.company_details)
        : {};
      this.model.postal_address = selectedSite.postal_address
        ? JSON.parse(selectedSite.postal_address)
        : {};
      this.model.delivery_address = selectedSite.delivery_address
        ? JSON.parse(selectedSite.delivery_address)
        : {};
      this.model.gst_billed_on_sales = selectedSite.gst_billed_on_sales
        ? selectedSite.gst_billed_on_sales
        : BASE_STATE.gst_billed_on_sales;
      this.model.gst_on_creditors = selectedSite.gst_on_creditors
        ? selectedSite.gst_on_creditors
        : BASE_STATE.gst_on_creditors;
      this.model.trade_creditors = selectedSite.trade_creditors
        ? selectedSite.trade_creditors
        : BASE_STATE.trade_creditors;
      this.model.trade_debtors = selectedSite.trade_debtors
        ? selectedSite.trade_debtors
        : BASE_STATE.trade_debtors;
      this.model.money_in_trust = selectedSite.money_in_trust
        ? selectedSite.money_in_trust
        : BASE_STATE.money_in_trust;
      this.model.job_retention = selectedSite.job_retention
        ? selectedSite.job_retention
        : BASE_STATE.job_retention;
      this.model.cheque_account = selectedSite.cheque_account
        ? selectedSite.cheque_account
        : BASE_STATE.cheque_account;
      this.model.delivery_bailing = selectedSite.delivery_bailing
        ? selectedSite.delivery_bailing
        : BASE_STATE.delivery_bailing;
      this.model.discounts_received = selectedSite.discounts_received
        ? selectedSite.discounts_received
        : BASE_STATE.discounts_received;
      this.model.retained_earnings = selectedSite.retained_earnings
        ? selectedSite.retained_earnings
        : BASE_STATE.retained_earnings;
      this.model.current_earnings = selectedSite.current_earnings
        ? selectedSite.current_earnings
        : BASE_STATE.current_earnings;
    },
    fetchSiteRelatedDetails(id) {
      if (id) {
        this.enableLoading();
        Promise.all([
          this.fetchJobSources(id), 
          this.fetchSalesStaff(id),
          this.fetchShopsBySite(id)
        ])
        .finally(this.disableLoading);
      }
    },
    fetchJobSources(id) {
      return axios.get(`api/sites/${id}/sources`).then(({ data }) => {
        this.jobSources = data.data;
      });
    },
    fetchSalesStaff(id) {
      return axios.get(`api/sites/${id}/sales_staff`).then(({ data }) => {
        this.salesStaffs = data.data;
      });
    },
    fetchShopsBySite(id) {
      return axios.get(`api/sites/${id}/shops`).then(({ data }) => {
        this.shops = data.data;
      });
    },
    fetchSites() {
      this.enableLoading();
      axios.get("api/sites").then(({ data }) => {
        this.sites = data.data;
        this.fetchUsersBySite(this.sites[0].id);
      })
      .catch(err => this.$toastr("error", "Could not get site data.", "Error!!"))
      .finally(this.disableLoading);
    },
    openJobSourceModal() {
      if (!this.mountJobSource) {
        this.mountJobSource = true;
      }
    },
    openAddStoreModal() {
      this.mountAddStore = true;
    },
    closeJobSourceModal() {
      this.mountJobSource = false;
      this.selectedJobSource = {};
    },
    closeAddShopModal() {
      this.mountAddShop = false;
      this.selectedShop = {};
    },
    closeAddStoreModal() {
      this.mountAddStore = false;
    },
    editJobSource(jobSource) {
      this.selectedJobSource = jobSource;
      this.openJobSourceModal();
    },
    editShop(shop) {
      this.selectedShop = shop;
      this.openAddShopModal();
    },
    openAddShopModal() {
      this.mountAddShop = true;
    },
    closeAddShopModal() {
      this.mountAddShop = false;
      this.selectedShop = {};
    },
    openSalesStaffModal() {
      this.mountSalesStaff = true;
    },
    closeSalesStaffModal() {
      this.selectedSalesStaff = {};
      this.mountSalesStaff = false;
    },
    editSalesStaff(salesStaff) {
      this.selectedSalesStaff = salesStaff;
      this.openSalesStaffModal();
    },
    enableEditMode() {
      this.modelCache = { ...this.model };
      this.changeEditMode(true);
    },
    cancelEditMode() {
      this.model = { ...this.modelCache };
      this.changeEditMode(false);
    },
    saveStoreData() {
      this.saveSetup();
      this.changeEditMode(false);
    },
    changeEditMode(status) {
      this.isEdit = !!status;
    },
    saveSetup() {
      const model = { ...this.model };
      model.company_details = isEmpty(this.model.company_details) ? null : this.model.company_details;
      model.postal_address = isEmpty(this.model.postal_address) ? null : this.model.postal_address;
      model.delivery_address = isEmpty(this.model.delivery_address) ? null : this.model.delivery_address;
      model.gst_billed_on_sales_id = this.model.gst_billed_on_sales.id;
      model.gst_on_creditors_id = this.model.gst_on_creditors.id;
      model.trade_creditors_id = this.model.trade_creditors.id;
      model.trade_debtors_id = this.model.trade_debtors.id;
      model.money_in_trust_id = this.model.money_in_trust.id;
      model.job_retention_id = this.model.job_retention.id;
      model.cheque_account_id = this.model.cheque_account.id;
      model.delivery_bailing_id = this.model.delivery_bailing.id;
      model.discounts_received_id = this.model.discounts_received.id;
      model.retained_earnings_id = this.model.retained_earnings.id;
      model.current_earnings_id = this.model.current_earnings.id;

      this.enableLoading();

      axios
        .put(`/api/sites/${this.selectedSite}`, model)
        .then(() => {
          this.$toastr("success", "Setup updated successfully.", "Success!!");
          window.location.href = "/setup";
        })
        .catch(() => {
          this.$toastr("error", "Could not update setup details.", "Error!!");
        })
        .finally(this.disableLoading);
    },
    salesStaffSaveHandler() {
      this.fetchSalesStaff(this.selectedSite);
    },
    jobSourceSaveHandler() {
      this.fetchJobSources(this.selectedSite);
    },
    shopSaveHandler() {
      this.fetchShopsBySite(this.selectedSite);
    },
    storeSavedHandler() {
      this.fetchSites();
    },
  }
};
</script>

<style scoped>
::-webkit-scrollbar {
    display: none;
}

.short-table td {
  padding: 0.5rem;
}
.short-table th {
  padding: 0.5rem;
  font-weight: 600;
}
.fm-flex {
  display: flex;
}
.fm-justify-center {
  justify-content: center;
}
.fm-justify-between {
  justify-content: space-between;
}
.background-black {
  background-color: black;
  color: #fff;
  width: fit-content;
  height: fit-content;
  padding: 4px;
}
</style>
