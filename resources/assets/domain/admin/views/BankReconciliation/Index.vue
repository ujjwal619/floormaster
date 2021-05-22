<template>
  <div class="form-container">
    <loading :loading="loading" />
    <div class="d-flex justify-content-between row pr-4">
      <span class="h4 background-black cash-book__header">
        Unpresented Debits
      </span>
      <span class="h4 background-black cash-book__header">
        Unbanked Receipts
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
                  <td class="form-control col-2">{{ debitItem.eft_cheque }}</td>
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
                  <td class="table-head col-4 text-right">Unpresented Debits: </td>
                  <td class="text-right table-head col-2">
                    {{ displayMoney(debitTotal) }}
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
                  <td class="table-head col-2">Type</td>
                  <td class="table-head col-3">Received From</td>
                  <td class="table-head col-2">Job</td>
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
                  <td class="form-control col-2">{{ creditItem.payment_type }}</td>
                  <td class="form-control col-3">{{ creditItem.payee }}</td>
                  <td class="form-control col-2">{{ creditItem.job ? creditItem.job.job_id : '' }}</td>
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
                  <td class="table-head col-4 text-right">Unpresented Credits: </td>
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
              <button type="button" class="btn action-buttons">Report</button>
              <button type="button" class="btn action-buttons" @click="redirectToCashBook">Cash Book</button>
              <button type="button" class="btn action-buttons" >Reconcile</button>
            </div>
            <div class="d-flex align-items-center">
              <span class="mr-2">Click on an item to record presentation</span>
            </div>
            <span class="background-black text-truncate mr-3 my-1">Bank Reconciliation</span>
          </div>
        </portlet-content>
      </div>
    </div>
    <edit-debit-or-credit
      v-if="mountEditDebitOrCredit"
      :site="selectedSite"
      :is-debit="isEditTypeDebit"
      :data="selectedCashBookItem"
      :cash-books="otherChequePayments"
      @update="fetchRecords"
      @close="closeModal('EditDebitOrCredit')"
    />
  </div>
</template>

<script>

import PortletContent from '../../../common/components/Portlets/Content/PortletContent';
import EditDebitOrCredit from './components/EditDebitOrCredit';
import DropDown from '../../../common/components/DropDown/DropDown';
import { LoadingMixin } from '../../../common/mixins';
import { getBankReconcilicationsBySite } from '../../api/calls';
import { formatViewDate, getFiscalYear, displayMoney } from '../../../common/utitlities/helpers';

const DEBIT = 1;
const CREDIT = 2;

const TOTAL_COUNT = 18;

export default {
  name: 'BankReconcilication',
  mixins: [LoadingMixin],
  components: {
    PortletContent,
    DropDown,
    EditDebitOrCredit,
  },
  data: () => ({
    mountEditDebitOrCredit: false,
    isDebit: false,
    sites: [],
    selectedSite: "",
    credit: [],
    debit: [],
    meta: {},
    selectedCashBookItem: {},
    defaultSite: '',
    otherChequePayments: [],
  }),
  watch: {
    selectedSite(siteId) {
      this.fetchCashBook(siteId);
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
      const debit = [...this.debit];
      for(let i = debit.length; i<TOTAL_COUNT; i++) {
        debit.push({});
      }
      return debit;
    },
    allCredits() {
      const credit = [...this.credit];
      for(let i = credit.length; i<TOTAL_COUNT; i++) {
        credit.push({});
      }
      return credit;
    },
  },
  created() {
    this.fetchSites();
  },
  methods: {
    formatViewDate,
    displayMoney,
    redirectToCashBook() {
      window.location.href = '/cash-book';
    },
    getChequeNumber(cashBook) {
      if (cashBook.remit_item_id) {
        const remittance = cashBook.remit_item.remittance || {};
        return remittance.payment_type === 1 ? 'E' + remittance.id : remittance.cheque_number;
      }

      return '';
    },
    getCashBookRowTotal(cashBook) {
      return cashBook.id ? `${displayMoney(cashBook.net_amount + cashBook.gst_credit)}` : '&nbsp;';
    },
    setSearchedCashBookData(par1, par2) {
      if (par1 === this.selectedSite) {
        return this.fetchCashBook(par1);
      }
      this.meta = par2;
      this.defaultSite = this.sites.find((site) => {
        return site.id === par1;
      });
    },
    fetchRecords() {
      this.fetchCashBook(this.selectedSite);
    },
    fetchCashBook(siteId) {
      const params = {from: getFiscalYear(), to: getFiscalYear('end')};
      this.enableLoading();
      return getBankReconcilicationsBySite(siteId, params)
        .then(({ data }) => {
          this.credit = data.data.filter(item => item.type === CREDIT);
          this.debit = data.data.filter(item => item.type === DEBIT);
        })
        .catch(err => this.$toastr("error", "Could not get bank reconciliation data.", "Error!!"))
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
      if(!item.id) {
        return;
      }

      this.otherChequePayments = [];
      this.selectedCashBookItem = item;
      const cashBooks = this.isEditTypeDebit ? [...this.debit] : [...this.credit];
      this.otherChequePayments = cashBooks.filter(cashBook => {
        if (cashBook.remit_item_id && item.remit_item_id) {
          const cashBookRemittance = cashBook.remit_item.remittance || {};
          const itemRemittance = item.remit_item.remittance || {};
          return cashBookRemittance.payment_type === itemRemittance.payment_type && cashBook.id !== item.id;
        }
        return cashBook.id !== item.id
      });
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
