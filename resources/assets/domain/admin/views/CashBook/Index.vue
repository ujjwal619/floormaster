<template>
  <div class="form-container">
    <loading :loading="loading" />
    <div class="d-flex justify-content-between row pr-4">
      <span class="h4 background-red cash-book__header">
        Debits <br/>
        (Out-Going)
      </span>
      <span class="text-warning h3">{{ meta.month_name }} {{ meta.year }}</span>
      <span class="h4 background-blue cash-book__header">
        Credits <br/>
        (Receipts)
      </span>
    </div>
    <div class="col-12 row pt-3">
        <span class="col-lg-1 text-right h4">Store:</span>
        <drop-down
            class="col-3"
            :options="sites"
            v-model="selectedSite"
            style="max-height: 40px;"
            :default-selected="defaultSite"
        />
    </div>
    <div class="row pt-3">
      <div class="col-6 row px-3">
        <div class="col-12">
          <div class="row table-wrap">
            <table class="table">
              <tbody>
                <tr class="row col-12">
                  <td class="table-head col-2">Date</td>
                  <td class="table-head col-2">Type</td>
                  <td class="table-head col-2">Cq No</td>
                  <td class="table-head col-4">Payee</td>
                  <td class="table-head col-2 text-right">Amount</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="row table-wrap" style="max-height: 500px;overflow-y: auto;">
            <table class="table">
              <tbody>
                <tr class="row col-12" v-for="debitItem in allDebits" :key="debitItem.id" @click="editHandler(debitItem)">
                  <td class="form-control col-2">{{ formatViewDate(debitItem.date) }}</td>
                  <td class="form-control col-2">{{ debitItem.payment_type }}</td>
                  <td class="form-control col-2">{{ getChequeNumber(debitItem) || debitItem.eft_cheque }}</td>
                  <td class="form-control col-4">{{ debitItem.payee }}</td>
                  <td class="form-control col-2 text-right text-danger" v-html="getCashBookRowTotal(debitItem)"></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="row pt-1 table-wrap">
            <table class="table">
              <tbody>
                <tr class="row col-12">
                  <td class="table-head col-6">&nbsp;</td>
                  <td class="table-head col-4 text-right">Total Debit: </td>
                  <td class="text-right table-head col-2">
                    ${{ debitTotal.toFixed(2) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-6 row pl-3">
        <div class="col-12">
          <div class="row table-wrap">
            <table class="table">
              <tbody>
                <tr class="row col-12">
                  <td class="table-head col-2">Date</td>
                  <td class="table-head col-3">Type</td>
                  <td class="table-head col-4">Received From</td>
                  <td class="table-head col-3">Amount</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="row table-wrap" style="max-height: 500px;overflow-y: auto;">
            <table class="table">
              <tbody>
                <tr class="row col-12" v-for="creditItem in allCredits" :key="creditItem.id"  @click="editHandler(creditItem)">
                  <td class="form-control col-2">{{ formatViewDate(creditItem.date) }}</td>
                  <td class="form-control col-3">{{ creditItem.payment_type }}</td>
                  <td class="form-control col-4">{{ creditItem.payee }}</td>
                  <td class="form-control col-3 text-right text-primary" v-html="getCashBookRowTotal(creditItem)"></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="row pt-1 table-wrap">
            <table class="table">
              <tbody>
                <tr class="row col-12">
                  <td class="table-head col-5">&nbsp;</td>
                  <td class="table-head col-4 text-right">Total Credit: </td>
                  <td class="text-right table-head col-3">
                    {{ displayMoney(creditTotal) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row pt-2">
      <div class="col-12 mt-2">
        <portlet-content :onlybody="true" isform="true">
          <div slot="body" class="menu-bar d-flex justify-content-between">
            <div class="mt-1">
              <button type="button" class="btn action-buttons" @click="openModal('SearchCashBook')">Search</button>
              <button type="button" class="btn action-buttons">Report</button>
              Click on Entry to Edit
              <button
                v-if="hasPermission('cash.book.add.entries')" 
                type="button" 
                class="btn action-buttons" 
                @click="openModal('AddToCashBook')"
              >Add</button>
              <button type="button" class="btn action-buttons" @click="redirectToBankReconciliation">Go To Bank Recon</button>
            </div>
            <div class="d-flex align-items-center">
              <span class="text-bold mr-2 cash-flow">Cash Flow: </span>
              <input type="text" class="form-control" disabled :value="displayMoney(totalCashBook)"/>
            </div>
            <span class="background-black text-truncate mr-3 my-1">Cash Book</span>
          </div>
        </portlet-content>
      </div>
    </div>
    <add-to-cash-book
      v-if="mountAddToCashBook"
      @debit="handleDebitOpen"
      @credit="handleCreditOpen"
      @close="closeModal('AddToCashBook')"
    />
    <add-debit-or-credit
      v-if="mountAddDebitOrCredit"
      :site="selectedSite"
      :is-debit="isDebit"
      @add="fetchRecords"
      @close="closeModal('AddDebitOrCredit')"
    />
    <edit-debit-or-credit
      v-if="mountEditDebitOrCredit"
      :site="selectedSite"
      :is-debit="isEditTypeDebit"
      :data="selectedCashBookItem"
      @update="fetchRecords"
      @close="closeModal('EditDebitOrCredit')"
    />
    <search-cash-book
      v-if="mountSearchCashBook"
      @selected="setSearchedCashBookData"
      @close="closeModal('SearchCashBook')"
    />
  </div>
</template>

<script>

import PortletContent from '../../../common/components/Portlets/Content/PortletContent';
import AddToCashBook from './components/AddToCashBook';
import AddDebitOrCredit from './components/AddDebitOrCredit';
import EditDebitOrCredit from './components/EditDebitOrCredit';
import SearchCashBook from './components/SearchCashBook';
import DropDown from '../../../common/components/DropDown/DropDown';
import { LoadingMixin, CurrentUserMixin } from '../../../common/mixins';
import { getCashBook } from '../../api/calls';
import { 
  formatViewDate, 
  alteredTableData,
  displayMoney
} from '../../../common/utitlities/helpers';

const DEBIT = 1;
const CREDIT = 2;

const TOTAL_COUNT = 17;

export default {
  name: 'CashBook',
  mixins: [LoadingMixin, CurrentUserMixin],
  components: {
    AddDebitOrCredit,
    AddToCashBook,
    PortletContent,
    SearchCashBook,
    DropDown,
    EditDebitOrCredit,
  },
  data: () => ({
    mountAddToCashBook: false,
    mountAddDebitOrCredit: false,
    mountSearchCashBook: false,
    mountEditDebitOrCredit: false,
    isDebit: false,
    sites: [],
    selectedSite: "",
    credit: [],
    debit: [],
    meta: {},
    selectedCashBookItem: {},
    defaultSite: '',
  }),
  watch: {
    selectedSite(siteId) {
      this.fetchCashBook(siteId, this.meta);
    },
  },
  computed: {
    debitTotal() {
      if (!this.debit.length) {
        return 0;
      }
      return this.debit.reduce((acc, item) => item.net_amount + item.gst_credit + acc, 0);
    },
    creditTotal() {
      if (!this.credit.length) {
        return 0;
      }
      return this.credit.reduce((acc, item) => item.net_amount + item.gst_credit + acc, 0);
    },
    isEditTypeDebit() {
      return this.selectedCashBookItem.type === DEBIT;
    },
    totalCashBook() {
      return Number(this.creditTotal) - Number(this.debitTotal);
    },
    allDebits() {
      return alteredTableData(this.debit, TOTAL_COUNT);
    },
    allCredits() {
      return alteredTableData(this.credit, TOTAL_COUNT);
    },
  },
  created() {
    this.fetchSites();
  },
  methods: {
    formatViewDate,
    displayMoney,
    redirectToBankReconciliation() {
      window.location.href = '/bank-reconciliation';
    },
    getChequeNumber(cashBook) {
      if (cashBook.remit_item_id) {
        const remittance = cashBook.remit_item.remittance || {};
        return remittance.payment_type === 1 ? 'E' + remittance.id : remittance.cheque_number;
      }
    },
    getCashBookRowTotal(cashBook) {
      return cashBook.id ? `${displayMoney(cashBook.net_amount + cashBook.gst_credit)}` : '&nbsp;';
    },
    setSearchedCashBookData(par1, par2) {
      if (par1 === this.selectedSite) {
        return this.fetchCashBook(par1, par2);
      }
      this.meta = par2;
      this.defaultSite = this.sites.find((site) => {
        return site.id === par1;
      });
    },
    fetchRecords() {
      this.fetchCashBook(this.selectedSite);
    },
    fetchCashBook(siteId, params = {}) {
      console.log(siteId, params);
      this.enableLoading();
      return getCashBook(siteId, params)
        .then(({ data }) => {
          this.credit = data.data.filter(item => item.type === CREDIT);
          this.debit = data.data.filter(item => item.type === DEBIT);
          this.meta = data.meta;
        })
        .catch(err => this.$toastr("error", "Could not get cash book data.", "Error!!"))
        .finally(this.disableLoading);
    },
    fetchSites() {
      this.enableLoading();
      axios.get("api/sites").then(({ data }) => {
        this.sites = data.data;
        this.defaultSite = this.sites[0];
      })
      .catch(err => this.$toastr("error", "Could not get site data.", "Error!!"))
      .finally(this.disableLoading);
    },
    openModal(type) {
      this[`mount${type}`] = true;
    },
    closeModal(type) {
      this[`mount${type}`] = false;
    },
    handleDebitOpen() {
      this.isDebit = true;
      this.openModal('AddDebitOrCredit');
    },
    handleCreditOpen() {
      this.isDebit = false;
      this.openModal('AddDebitOrCredit');
    },
    editHandler(item) {
      if (!item.id || !this.hasPermission('cash.book.edit.entries')) {
        return;
      }
      
      this.selectedCashBookItem = item;
      this.openModal('EditDebitOrCredit')
    },
  },
};
</script>

<style scoped>
.cash-book__header {
  color: #fff;
  width: fit-content;
  height: fit-content;
  padding: 4px;
}

.background-red {
  background-color: red;
}
.background-blue {
  background-color: blue;
}
.form-control {
  line-height: 24px !important;
}
.cash-flow {
  min-width: 90px;
}
</style>
