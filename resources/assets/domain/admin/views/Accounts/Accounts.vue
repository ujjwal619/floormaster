<script>
import PortletContent from "../../../common/components/Portlets/Content/PortletContent";
import AccountsTable from "./AccountsTable";
import NewAccountsModal from "./NewAccountsModal";
import UpdateModal from "./UpdateModal";
import RebuildChartBalanceModal from "./RebuildChartBalanceModal";
import ClosePeriodModal from './ClosePeriodModal';
import FmError from '../../../common/components/Error/FmError';
import { TABS } from "./tabs";
import { LoadingMixin, CurrentUserMixin } from "../../../common/mixins";
import DropDown from "../../../common/components/DropDown/DropDown";
import { 
  getViewFiscalYear, 
  getFiscalYear,
  getFiscalMonths
} from '../../../common/utitlities/helpers';
import { getSites, getAccountsBySite } from '../../api/calls'

export default {
  name: "Accounts",
  mixins: [LoadingMixin, CurrentUserMixin],
  components: {
    PortletContent,
    AccountsTable,
    NewAccountsModal,
    DropDown,
    UpdateModal,
    RebuildChartBalanceModal,
    ClosePeriodModal,
    FmError
  },
  TABS,
  data: () => ({
    currentTab: TABS[0].id,
    mountNewAccountsModal: false,
    mountUpdateModal: false,
    mountRebuildChartBalance: false,
    accounts: [],
    selectedAccount: {},
    sites: [],
    selectedSite: '',
    selectedMonth: {},
    accountTotalType: 'financial_year',
    accountTotalDate: getFiscalYear(),
    mountClosePeriod: false,
    mountCurrentYearError: false,
  }),
  computed: {
    selectedTabData() {
      return TABS.find(tab => tab.id === this.currentTab);
    },
    headerAccounts() {
      return this.accounts.filter(account => account.type === 1);
    },
    selectedSiteData() {
      return this.sites.find(site => site.id === this.selectedSite);
    },
    isGlRecordingOff() {
      if (!this.selectedSiteData) {
        return true;
      }
      return !this.selectedSiteData.gl_recording;
    },
    updateButtonTitle() {
      return this.isGlRecordingOff ? 'G.L. Recording is Off' : '';
    },
    allMonths() {
      const allMonth = {
        name: 'All Months',
        id: 'all_months',
        date: getFiscalYear(),
        type: 'financial_year'
      };
      return [allMonth, ...getFiscalMonths()]
    },
  },
  watch: {
    currentTab: {
      immediate: false,
      handler(value) {
        this.fetchAccounts(value, this.selectedSite);
      }
    },
    selectedSite: {
      handler(id) {
        this.currentTab = TABS[0].id;
        this.fetchAccounts(this.currentTab, id);
      }
    },
    selectedMonth: {
      handler(month) {
        if (month.date) {
          this.accountTotalDate = month.date;
          this.accountTotalType = month.type;
          this.fetchAccounts();
        }
      }
    }
  },
  created() {
    this.fetchSites();
  },
  methods: {
    getViewFiscalYear,
    selectTab(id) {
      if (id) {
        this.currentTab = id;
      }
    },
    addNewAccount() {
      this.mountNewAccountsModal = true;
    },
    openUpdateModal() {
      this.mountUpdateModal = true;
    },
    closeNewAccount() {
      this.selectedAccount = {};
      this.mountNewAccountsModal = false;
    },
    handleRebuild() {
      this.mountRebuildChartBalance = false;
      this.enableLoading()
      axios.post(`/api/sites/${this.selectedSite}/accounts/rebuild`)
        .then(() => {
          this.$toastr('success', 'Successfully rebuild chart balances', 'Success!!');
          this.handleAccountSave();
        })
        .catch(() => {
          this.$toastr('error', 'Could not rebuild chart balances', 'Error!!')
        })
        .finally(this.disableLoading);
    },
    fetchSites() {
      this.enableLoading();
      getSites()
        .then(({ data }) => {
          this.sites = data.data;
        })
        .catch(err => this.$toastr("error", "Could not get site data.", "Error!!"))
        .finally(this.disableLoading);
    },
    fetchAccounts(
      familyId = this.currentTab, 
      selectedSite = this.selectedSite, 
      periodType = this.accountTotalType, 
      date = this.accountTotalDate
    ) {
      this.enableLoading();
      getAccountsBySite(selectedSite, {
        family_id: familyId, 
        period_type: periodType, 
        date: date
      })
        .then(({ data }) => {
          this.accounts = data.data;
        })
        .catch(() => {
          this.$toastr('error', 'Could not fetch accounts.', 'Error!!')
        })
        .finally(this.disableLoading);
    },
    handleAccountSave() {
      this.fetchAccounts(this.currentTab, this.selectedSite);
    },
    openEditModal(account) {
      this.selectedAccount = { ...account };
      this.mountNewAccountsModal = true;
    },
    findSite(id) {
      return this.sites.find((site) => site.id === id);
    },
  }
};
</script>

<style scoped>
.active {
  border-bottom: 0;
  font-weight: 600;
  margin-bottom: -2px;
  box-shadow: 1px 1px 2px 0.1rem rgba(40, 89, 121, 0.2) inset !important;
}

.tab-selector {
  height: 45px;
}

.tab-selector:not(:last-child) {
  margin-right: 1rem;
}

.background-black {
  background-color: black;
  color: white;
  width: fit-content;
}
</style>

