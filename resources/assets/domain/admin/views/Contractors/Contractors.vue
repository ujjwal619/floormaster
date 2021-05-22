<script>
//@TODO: find code and supplier name of Deductions and Tax liability

import axios from "axios";
import PortletContent from "../../../common/components/Portlets/Content/PortletContent";
import TrashOrKeep from '../../../common/components/TrashOrKeep'
import { getSites } from '../../api/calls.js'
import Add from "./components/Add";
import ContractorPayableRecord from "./components/ContractorPayableRecord";
import NewContractor from "./components/NewContractor";
import SelectAccount from "./components/SelectAccount";
import Remit from '../Payables/components/Remit';
import RemitPrint from "./components/RemitPrint";
import SelectSupplierAccount from "./components/SelectSupplierAccount";
import SelectPayment from './components/SelectPayment';
import DropDown from '../../../common/components/DropDown/DropDown'
import { LoadingMixin, CurrentUserMixin } from '../../../common/mixins'
import SearchContractor from './components/SearchContractor';
import StateModal from '../../../common/components/StateModal'
import { formatViewDate, displayMoney } from '../../../common/utitlities/helpers';

const TITLES = {
  contractor_liability_account: "Payable Liability",
  sales: "Cost of Sales"
};

const SUPPLIER_TITLES = {
  tax_liability_account: "Select Tax Payee & Tax Liability Account",
  deductions: "Select Supplier & Deduction Account"
};

const BASE_SUPPLIER_ACC = {
  supplier: null,
  supplier_name: "",
  account: null,
  account_name: ""
};

const PAY = 1;
const HOLD = 2;

export default {
  name: "Contractors",
  mixins: [LoadingMixin, CurrentUserMixin],
  components: {
    Add,
    RemitPrint,
    ContractorPayableRecord,
    DropDown,
    NewContractor,
    PortletContent,
    SelectAccount,
    SelectSupplierAccount,
    SelectPayment,
    TrashOrKeep,
    SearchContractor,
    StateModal,
    Remit
  },
  props: {
    contractor: {
      type: Object,
      default: () => ({})
    },
    suppliers: {
      type: Array,
      default: () => [],
    },
    liabilityAccount: {
      type: Array,
      default: () => [],
    },
    costOfSalesAccount: {
      type: Array,
      default: () => [],
    },
    payments: {
      type: Array,
      default: () => [],
    },
    jobs: {
      type: Array,
      default: () => ([]),
    },
    next: {
      type: Number,
      default: 0
    },
    previous: {
      type: Number,
      default: 0
    },
  },
  PAY,
  HOLD,
  data: () => ({
    currentPage: 1,
    mountStateModal: false,
    mountAddModal: false,
    mountNewContractor: false,
    mountSelectAccount: false,
    mountSupplierAccount: false,
    mountAddPayableModal: false,
    mountSearchContractor: false,
    mountTrashOrKeep: false,
    selectedPayableData: {},
    pickedAccount: "",
    pickedSupplierAccount: "",
    taxLiabilityOptions: [],
    bank: {},
    tax_liability_account: {},
    deductions: {},
    public_liability_insurance: {},
    workers_comp_insurance: {},
    model: {},
    sites: [],
    isEditMode: true,
    remit: {
      notes: [],
    },
    mountSelectPayment: false,
  }),
  computed: {
    remitPayeeDetails() {
      if (!this.remit || !Object.keys(this.remit).length) {
        return {};
      }
      return {
        payee_name: this.remit.supplier.trading_name || this.remit.payee_name,
        payee_code: this.remit.supplier.code || this.remit.payee_code,
        state: this.remit.supplier.state || this.remit.payee_state,
        street: this.remit.supplier.street || this.remit.payee_street,
        town: this.remit.supplier.suburb || this.remit.payee_town,
      };
    },
    siteName() {
      return this.isOldEntry ? this.contractor.site.name : '';
    },
    isOldEntry() {
      return !!this.model.id;
    },
    accounts() {
      return this.pickedAccount === 'cost_of_sales_account' ? this.costOfSalesAccount : this.liabilityAccount;
    },
    accountTitle() {
      return TITLES[this.pickedAccount] || "";
    },
    supplierAccountTitle() {
      return SUPPLIER_TITLES[this.pickedSupplierAccount] || "";
    },
    accountOptions() {
      return [];
    },
    getPayloadData() {
      return {
        ...this.model,
        bank: this.bank,
        tax_liability_account: this.tax_liability_account,
        deductions: this.deductions,
        public_liability_insurance: this.public_liability_insurance,
        workers_comp_insurance: this.workers_comp_insurance
      };
    },
    getPaymentTotal() {
      return this.payments.reduce((amt, acc) => acc.amount + amt, 0);
    },
    getGstTotal() {
      return Number.parseFloat(this.payments.reduce((amt, acc) => ((Number(acc.amount) * Number(acc.gst)) / 100) + amt, 0)).toFixed(2);
    },
    getFinalTotal() {
      return Number(this.getPaymentTotal) + Number(this.getGstTotal);
    }
  },
  created() {
    if (this.contractor.id) {
      this.model = this.contractor;
      this.model.contractor_liability_account_code = this.findLiabilityAccount(this.contractor.contractor_liability_account).code;
      this.model.cost_of_sales_account_code = this.findCostOfSalesAccount(this.contractor.cost_of_sales_account).code;
      this.bank = this.contractor.bank || {};
      this.tax_liability_account = this.checkIsNotEmptyArrayOrEmptyObject(
        this.contractor.tax_liability_account
      )
        ? this.contractor.tax_liability_account
        : {
            ...BASE_SUPPLIER_ACC
          };
      this.deductions = this.checkIsNotEmptyArrayOrEmptyObject(
        this.contractor.deductions
      )
        ? this.contractor.deductions
        : {
            ...BASE_SUPPLIER_ACC
          };
      this.public_liability_insurance = this.checkIsNotEmptyArrayOrEmptyObject(
        this.contractor.public_liability_insurance
      )
        ? this.contractor.public_liability_insurance
        : {};
      this.workers_comp_insurance = this.checkIsNotEmptyArrayOrEmptyObject(
        this.contractor.workers_comp_insurance
      )
        ? this.contractor.workers_comp_insurance
        : {};
    }
    this.fetchSites();
  },
  methods: {
    formatViewDate,
    displayMoney,
    redirectToJob(job) {
      window.location.href = `/jobs/${job.id}/edit?page=2`
    },
    getRemittanceItemsTotal(key) {
      if (!this.model.remittance_items || !this.model.remittance_items.length) {
        return 0;
      }
      return this.model.remittance_items.reduce((acc, item) => acc + item[key], 0);
    },
    mediaButton(action) {
      if (action === 'prev' && this.previous) {
        window.location.href = `/contractors/${this.previous}/edit`
      }
      if (action === 'next' && this.next) {
        window.location.href = `/contractors/${this.next}/edit`
      }
    },
    remitCompleted() {
      this.currentPage = 1;
      // window.location.href = '/contractors';
    },
    remitContractor() {
      this.enableLoading();
      const items = this.remit.items.map(remit => remit.id);
      axios.put(`/api/remittances/${this.remit.id}/remit`, {items: items})
        .then(() => {
          this.currentPage = 4
        })
        .catch(error => console.log('error remitting remittance.'))
        .finally(() => this.disableLoading());
    },
    changeItemStatus(id) {
      const item = this.remit.items.find(item => item.id === id);
      const payLoad = { ...item, status: item.status === PAY ? HOLD : PAY };
      // update item status by sending an axios request;
      console.log(payLoad);
    },
    getTotal(key) {
      if (!this.remit.items || !this.remit.items.length) {
        return 0;
      }
      return this.remit.items.reduce((acc, item) => acc + item[key], 0);
    },
    saveRemit() {
      this.enableLoading();
      axios.put(`/api/remittances/${this.remit.id}`, { ...this.remit })
        .then(() => {
          this.remitCache = { ...this.remit };
          this.$toastr(
            "success",
            `Successfully updated Remittance data`,
            "Success!!"
          );
          this.cancelRemitEditMode();
        })
        .catch(error => {
          this.$toastr("error", `Could not update Remittance data`, "Error!!");
        })
        .finally(() => this.disableLoading());
    },
    cancelRemitEditMode() {
      this.remit = this.remitCache;
      this.changeEditMode(false);
    },
    handleRemitPaid(data) {
      this.loadRemit(data.id);
    },
    updateRemit() {
      this.loadRemit(this.remit.id);
    },
    loadRemit(id) {
      this.enableLoading()
      axios.get(`/api/remittances/${id}`)
        .then(({ data }) => {
          this.remit = Object.assign({}, { ...this.remit }, { ...data.data } );
          if (this.remit.contractor_id) {
            this.remit.payee_name = this.remit.contractor.name;
            this.remit.payee_street = this.remit.contractor.street;
            this.remit.payee_town = this.remit.contractor.suburb;
            this.remit.payee_state = this.remit.contractor.state;
            this.remit.payee_code = this.remit.contractor.postcode;
            this.remit.notes = this.remit.notes || {};
          }
          this.remitCache = { ...this.remit } ; 
          this.currentPage = 3;
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },
    fetchSites() {
      this.enableLoading();
      getSites()
        .then(({ data }) => {
          this.sites = data.data;
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },
    findLiabilityAccount(id) {
      return this.liabilityAccount.find(account => account.id === Number(id)) || {};
    },
    findCostOfSalesAccount(id) {
      return this.costOfSalesAccount.find(account => account.id === Number(id)) || {};
    },
    checkIsNotEmptyArrayOrEmptyObject(value) {
      if (!value) {
        return false;
      }
      return !!Object.keys(value).length;
    },
    openAddPayable() {
      this.mountAddPayableModal = true;
    },
    closeAddPayable() {
      this.mountAddPayableModal = false;
    },
    closeAddModal() {
      this.mountAddModal = false;
    },
    openAddModal() {
      this.mountAddModal = true;
    },
    openNewContractor() {
      this.mountNewContractor = true;
    },
    closeNewContractor() {
      this.mountNewContractor = false;
    },
    openSelectAccount() {
      this.mountSelectAccount = true;
    },
    closeSelectAccount() {
      this.mountSelectAccount = false;
    },
    openSupplierAccount() {
      this.mountSupplierAccount = true;
    },
    closeSupplierAccount() {
      this.mountSupplierAccount = false;
    },
    pickAccount(type) {
      this.pickedAccount = type;
      this.openSelectAccount();
    },
    pickSupplierAccount(type) {
      this.pickedSupplierAccount = type;
      this.openSupplierAccount();
    },
    changeEditMode(flag) {
      this.isEditMode = !!flag;
    },
    editContractor() {
      const payLoad = { ...this.getPayloadData };
      const method = this.isOldEntry ? 'put' : 'post';
      const url = this.isOldEntry ? `/contractors/${this.contractor.id}` : '/contractors';
      const message = this.isOldEntry ? 'update' : 'create';
      this.enableLoading();
      axios[method](url, payLoad)
        .then(() => {
          window.location.href = `/contractors`;
          this.$toastr(
            "success",
            `Successfully ${message}d contractor data.`,
            "Success!!"
          );
        })
        .catch(() => {
          this.$toastr("error", `Could not ${message} contractor data.`, "Error!!");
        })
        .finally(() => this.disableLoading());
    },
    accountSelected({ type, selectedOption }) {
      this.model[type] = selectedOption.id;
      this.model[`${type}_code`] = selectedOption.code;
    },
    supplierAccountSelected({ type, selectedOption }) {
      this[type].supplier = selectedOption.supplier.id;
      this[type].supplier_name = selectedOption.supplier.trading_name;
      this[type].account = selectedOption.account.id;
      this[type].account_code = selectedOption.account.code;
    },
    newPayable() {
      this.selectedPayableData = {};
      this.openAddPayable();
    },
    editPayableData(payable) {
      this.selectedPayableData = payable;
      this.openAddPayable();
    },
    openModal(type) {
      if (type) {
        this[`mount${type}`] = true;
      }
    },
    closeModal(type) {
      if (type) {
        this[`mount${type}`] = false;
      }
    },
    handleSelectedContractor(contractor) {
      this.closeModal('SearchContractor');
      window.location.href = `/contractors/${contractor}/edit`
    },
    selectNewState({ state, suburb, code }) {
      this.model.state = state;
      this.model.suburb = suburb;
      this.model.postcode = code;
    },
  }
};
</script>

<style scoped>
.background-black {
  background-color: black;
  color: white;
  width: fit-content;
  padding: 3px;
}
.portlet-table {
  margin-top: 10px !important;
}
::-webkit-scrollbar {
    display: none;
}
</style>
