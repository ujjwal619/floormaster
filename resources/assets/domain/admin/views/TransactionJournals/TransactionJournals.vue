<template>
  <div class="form-container">
    <loading :loading="loading" />
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
    <div class="row pt-2 pb-2">
      <div class="col-12 ml-1">
        <button
          v-for="(item, index) in $options.TABS"
          :key="index"
          type="button"
          class="btn col-1 tab-selector"
          :class="{ active: currentTab === item.id }"
          @click="selectTab(item.id)"
        >
          {{ item.name }}
        </button>
      </div>
		</div>
    <all-table
      v-show="$options.ALL === currentTab"
      :journals="journals"
      @edit="openEditModal"
    />
    <general-table
      v-show="$options.GENERAL === currentTab"
      :journals="journals"
      @edit="openEditModal"
    />
    <purchase-table
      v-show="$options.PURCHASES === currentTab"
      :journals="journals"
      @edit="openEditModal"
    />
    <inventory-table
      v-show="$options.INVENTORY === currentTab"
      :journals="journals"
      @edit="openEditModal"
    />
    <sales-table
      v-show="$options.SALES === currentTab"
      :journals="journals"
      @edit="openEditModal"
    />
    <receipts-table
      v-show="$options.RECEIPTS === currentTab"
      :journals="journals"
      @edit="openEditModal"
    />
    <disbursements-table
      v-show="$options.DISBURSEMENTS === currentTab"
      :journals="journals"
      @edit="openEditModal"
    />
    <set-date-range-modal
      v-if="mountSetDateRange"
      :meta-data="{from: from, to: to}"
      @close="closeModal('SetDateRange')"
      @selected="setNewDateRange"
    />
    <add-transaction-journal 
      v-if="mountAddTransactionJournal"
      @close="closeNewAccount"
    />
    <div class="col-xsmall-12 col-small-12 mt-3">
			<portlet-content isform="true" :onlybody="true">
					<div slot="body" class="menu-bar d-flex justify-content-between">
							<div class="mt-1">
									<button type="button" class="btn action-buttons">Report</button>
									<button type="button" class="btn action-buttons" @click="addTransactionJournal">
                    Add
                  </button>
                  <button type="button" class="btn action-buttons" @click="openModal('SetDateRange')">
                    Set>>
                  </button>
                  <span class="text-black">Display Range: {{ formatViewDate(from) }} to {{ formatViewDate(to) }}</span>
							</div>
							<span class="background-black text-truncate mr-3 my-1 p-1">
									Transaction Journal - {{ selectedTabData.name }}
							</span>
					</div>
			</portlet-content>
	</div>
  </div>
</template>
<script>
import PortletContent from "../../../common/components/Portlets/Content/PortletContent";
import AllTable from "./components/AllTable";
import GeneralTable from "./components/GeneralTable";
import PurchaseTable from "./components/PurchaseTable";
import InventoryTable from "./components/InventoryTable";
import SalesTable from "./components/SalesTable";
import ReceiptsTable from "./components/ReceiptsTable";
import DisbursementsTable from "./components/DisbursementsTable";
import AddTransactionJournal from "./components/AddTransactionJournal";
import SetDateRangeModal from "./components/SetDateRangeModal";
import { 
  TABS, 
  ALL,
  GENERAL,
  PURCHASES,
  INVENTORY,
  SALES,
  RECEIPTS,
  DISBURSEMENTS,
  findTab
} from "./tabs";
import { LoadingMixin } from "../../../common/mixins";
import DropDown from "../../../common/components/DropDown/DropDown";
import { getTransactionJournalsBySite, getSites } from "../../api/calls";
import { 
  getFiscalYear,
  formatViewDate,
} from "../../../common/utitlities/helpers";

export default {
  name: "TransactionJournals",
  mixins: [LoadingMixin],
  components: {
    PortletContent,
    AllTable,
    GeneralTable,
    PurchaseTable,
    InventoryTable,
    SalesTable,
    ReceiptsTable,
    DisbursementsTable,
    AddTransactionJournal,
    DropDown,
    SetDateRangeModal
  },
  TABS,
  ALL,
  GENERAL,
  PURCHASES,
  INVENTORY,
  SALES,
  RECEIPTS,
  DISBURSEMENTS,
  data: () => ({
    currentTab: TABS[0].id,
    mountAddTransactionJournal: false,
    mountSetDateRange: false,
    journals: [],
    selectedJournal: {},
    sites: [],
    selectedSite: '',
    from: getFiscalYear(),
    to: getFiscalYear('end'),
  }),
  computed: {
    selectedTabData() {
      return findTab(this.currentTab);
    },
    selectedSiteData() {
      return this.sites.find(site => site.id === this.selectedSite);
    },
  },
  watch: {
    currentTab: {
      immediate: false,
      handler(value) {
        this.fetchTransactionJournalsBySite(value, this.selectedSite);
      }
    },
    selectedSite: {
      handler(id) {
        this.fetchTransactionJournalsBySite(this.currentTab, id);
      }
    }
  },
  created() {
    this.fetchSites();
    getFiscalYear();
  },
  methods: {
    formatViewDate,
    setNewDateRange({from, to}) {
      this.from = from;
      this.to = to;
      this.handleAccountSave();
    },
    openModal(type) {
      if(type) {
        this[`mount${type}`] = true;
      }
    },
    closeModal(type) {
      if(type) {
        this[`mount${type}`] = false;
      }
    },
    selectTab(id) {
      if (id) {
        this.currentTab = id;
      }
    },
    addTransactionJournal() {
      // this.mountAddTransactionJournal = true;
    },
    closeNewAccount() {
      this.selectedJournal = {};
      this.mountAddTransactionJournal = false;
    },
    fetchSites() {
      this.enableLoading();
      getSites()
        .then(({ data }) => {
          this.sites = data.data;
        })
        .catch(err => this.$toastr("error", "Could not get site data.", "Error!!"))
    },
    fetchTransactionJournalsBySite(familyId, selectedSite) {
      this.enableLoading();
      getTransactionJournalsBySite(selectedSite, {
        type: familyId,
        from: this.from,
        to: this.to,
      })
        .then(({ data }) => {
          this.journals = data.data;
        })
        .finally(this.disableLoading);
    },
    handleAccountSave() {
      this.fetchTransactionJournalsBySite(this.currentTab, this.selectedSite);
    },
    openEditModal(journal) {
      this.selectedJournal = { ...journal };
      // this.mountAddTransactionJournal = true;
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

::-webkit-scrollbar {
    display: none;
}
</style>

