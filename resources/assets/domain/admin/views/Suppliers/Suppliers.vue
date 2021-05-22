
<script>
  import {isEmpty, formatViewDate, displayMoney} from "../../../common/utitlities/helpers"
  import PortletContent from '../../../common/components/Portlets/Content/PortletContent'
  import StateModal from '../../../common/components/StateModal'
  import TrashOrKeep from '../../../common/components/TrashOrKeep'
  import DropDown from '../../../common/components/DropDown/DropDown'
  import Modal from '../../../common/components/Modal/Modal'
  import SearchSupplier from './components/SearchSupplier'
  import { 
    getSites, 
    getSuppliersReport, 
    getRemittanceById 
  } from '../../api/calls.js'
  import SelectAccount from "../Contractors/components/SelectAccount";
  import SelectPayment from './components/SelectPayment'
  import AddRemittance from './components/AddRemittance'
  import Remit from '../Payables/components/Remit';
  import RemitPrint from './components/RemitPrint'
  import { LoadingMixin } from '../../../common/mixins'
  import SelectCentralBilling from "./components/SelectCentralBilling"
  import FmFilter from "../../../common/components/fmFilter/Index"
  import FmTableSortable from '../../../common/components/fmTable/Sortable.vue'
  import FmPagination from '../../../common/components/FmPagination.vue'

  const PAY = 1;
  const HOLD = 2;

  const FILTERS = [
    {
      key: 'id',
      label: 'Id',
      type: 'Number',
    },
    {
      key: 'trading_name',
      label: 'Name',
      type: 'String',
    },
  ];

  const BASE_STATE = {
    site_id: '',
    trading_name: '',
    street: '',
    suburb: '',
    town: '',
    state: '',
    code: '',
    fax: '',
    abn: '',
    contact: '',
    key_no: '',
    email: '',
    sales_detail: {
      phone: '',
      quick_dial: '',
      fax: '',
      contact: '',
    },
    early_discount: {
      discount: '',
      end_of_month: '',
      invoice_date: '',
      bi_monthly: '',
    },
    normal_discount: {
      discount: '',
      end_of_month: '',
      invoice_date: '',
      late_factor: '',
    },
    bank: {
      ac_name: '',
      bank: '',
      ac_no: '',
      eft: '',
      branch: '',
      bsb: '',
    },
    default_cost_account: {
      name: '',
      id: '',
      code: '',
    },
    levy_account: {
      name: '',
      id: '',
      code: '',
    },
    levy_percent: '',
    delivery: '',
    central_billing: {
      name: '',
      id: '',
    },
    products: {
      notes: '',
      product_counter: '',
      uses_order_ref: '',
    },
  };

  const TABLE_COLUMNS = [
    {
      id: 'id',
      label: 'Id',
    },
    {
      id: 'trading_name',
      label: 'Name',
    },
    {
      id: 'site_name',
      label: 'Store',
    },
  ];

  const DEFAULT_PARAMS = {
    page: 1,
    per_page: 10,
    sort: 'id',
    filters: {},
  };

  export default {
    name: "Suppliers",
    mixins: [LoadingMixin],
		components: {
      AddRemittance,
			PortletContent,
      Modal,
      DropDown,
      SearchSupplier,
      SelectPayment,
      SelectAccount,
      RemitPrint,
      TrashOrKeep,
      StateModal,
      SelectCentralBilling,
      FmFilter,
      FmTableSortable,
      FmPagination,
      Remit
		},
    AUTO_PAY_ID: 1,
    MANUAL_PAY_ID: 2,
    PAY,
    HOLD,
    FILTERS,
    TABLE_COLUMNS,
    props: {
      supplierId: {
        type: Number,
        default: 0
      }
    },
		data() {
			return {
        logs: [],
        query: DEFAULT_PARAMS,
        pagination: {},
        currentPage: 1,
        alteredFilters: FILTERS,
        model: { ...BASE_STATE },
        modelCache: { ...BASE_STATE },
        remit: {
          notes: [],
        },
        selectedSite: '',
        sites: [],
        mountStateModal: false,
        isEditMode: false,
        mountSearchSupplier: false,
        mountSelectPayment: false,
        siteName: '',
        mountSelectAccount: false,
        mountSelectCentralBilling: false,
        mountAddRemittance: false,
        mountTrashOrKeep: false,
        accountModalFor: '',
        accountModalTitle: '',
        accounts: [],
        sortableColumns: {
          id: 'dsc',
          trading_name: 'default',
          site_name: 'default',
        },
			};
    },
    computed: {
    isDefaultCostAccountRequired() {
        return !!this.model.levy_percent && !this.model.default_cost_account.code;
      },
      payables() {
        return this.model.payables || [];
      },
      totalPayables() {
        const amount = this.payables.reduce((sum, payable) => {
          return Number(sum) + Number(payable.expected_amount);
        }, 0);

        return amount.toFixed(2);
      },
      isOldEntry() {
        return !!this.model.id;
      },
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
    },
    watch: {
      query: {
        deep: true,
        handler(value) {
          console.log(value);
          this.fetchSuppliers(value);
        },
      },
    },
    created() {
      this.fetchSites();
      if (!this.supplierId) {
        this.fetchSupplierIndex();
      } else {
        this.fetchSupplier(this.supplierId);
      }
    },
		methods: {
      formatViewDate,
      displayMoney,
      exportSupplierReport() {
        window.location.href = `/api/suppliers/report/export?${$.param(this.query)}`;
      },
      setFilters(filters = {}) {
        const page = 1;
        this.setQuery({ page, ...filters });
      },
      setSort({ sort, sortable }) {
        this.sortableColumns = { ...sortable };
        const page = 1;
        this.setQuery({ sort, page });
      },
      setQuery(params = {}) {
        console.log('setquery', params);
        const { query } = this;
        this.$nextTick(() => {
          this.query = {
            ...query,
            ...params,
          };
        });
      },
      openReportPage() {
        this.currentPage = 5;
        const sites = this.sites.map(site => {
          return {id: site.name, value: site.name};
        })
        this.alteredFilters.push({
          key: 'site_name',
          label: 'Store',
          type: 'Select',
          options: sites,
        })
        this.fetchSuppliers();
      },
      goToPayable(payable) {
        window.location.href = `/payables?payable=${payable.id}`;
      },
      deleteSupplier() {
        let confirmation = confirm('Are you sure you want to delete?');
        if (confirmation) {
          axios.delete(`/api/suppliers/${this.model.id}`)
            .then(() => {
              this.$toastr('success', 'Successfully deleted supplier.', 'Success!!');
              this.fetchSupplierIndex();
            })
            .catch(() => {
              this.$toastr('error', 'Could not delete supplier', 'Error!!')
            })
            .finally(this.handleClose);
        }
      },
      remitSupplier() {
        // delete supplier payables item
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
      getRemittanceItemsTotal(key) {
        if (!this.model.remittance_items || !this.model.remittance_items.length) {
          return 0;
        }
        return this.model.remittance_items.reduce((acc, item) => acc + item[key], 0);
      },
      getTotalPayment() {
        if (!this.model.remittance_items || !this.model.remittance_items.length) {
          return 0;
        }
        const total = this.model.remittance_items.reduce((acc, item) => acc + item.invoice_amount + item.adjustment, 0);
        return Number(total);
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
        this.enableLoading();
        getRemittanceById(id)
          .then(({ data }) => {
            this.remit = Object.assign({}, { ...this.remit }, { ...data.data } );
            if (this.remit.supplier_id) {
              this.remit.payee_name = this.remit.supplier.trading_name;
              this.remit.payee_street = this.remit.supplier.street;
              this.remit.payee_town = this.remit.supplier.suburb;
              this.remit.payee_state = this.remit.supplier.state;
              this.remit.payee_code = this.remit.supplier.code;
              this.remit.notes = this.remit.notes || [];
            }
            this.remitCache = { ...this.remit } ; 
          this.currentPage = 3;
          })
          .catch(error => console.log(error))
          .finally(() => this.disableLoading());
      },
      handleSelectedSupplier(supplier) {
        this.closeModal('SearchSupplier');
        this.fetchSupplier(supplier);
      },
      accountSelected({ type, selectedOption }) {
        this.model[type] = selectedOption;
      },
      centralBillingSelected(centralBilling) {
        this.model.central_billing = centralBilling;
      },
      openSelectAccount() {
        this.mountSelectAccount = true;
      },
      openSelectCentralBilling() {
        this.mountSelectCentralBilling = true;
      },
      closeSelectAccount() {
        this.mountSelectAccount = false;
      },
      closeSelectCentralBilling() {
        this.mountSelectCentralBilling = false;
      },
      pickAccount(type, title) {
        this.enableLoading();
        axios.get(`/api/sites/${this.model.site_id}/suppliers/accounts`)
          .then(({ data }) => {
            this.accounts = data.data;
          })
          .catch()
          .finally(this.disableLoading);
        this.accountModalFor = type;
        this.accountModalTitle = title;
        this.openSelectAccount();
      },
      saveHandler() {
        this.saveSupplier();
      },
      saveSupplier() {
        this.validate().then(valid => {
          if (valid && !this.isDefaultCostAccountRequired) {
            this.enableLoading();
            const method = this.isOldEntry ? "put" : "post";
            const url = this.isOldEntry ? `/suppliers/${this.model.id}` : `/suppliers`;
            const msg = this.isOldEntry ? "update" : "create";
            const model = { ...this.model };
            model.default_cost_account = this.model.default_cost_account.id ? this.model.default_cost_account.id : '';
            model.levy_account = this.model.levy_account.id ? this.model.levy_account.id : '';
            model.central_billing = this.model.central_billing.id;
            model.sales_detail = isEmpty(this.model.sales_detail) ? null : this.model.sales_detail;
            model.bank = isEmpty(this.model.bank) ? null : this.model.bank;
            model.early_discount = isEmpty(this.model.early_discount) ? null : this.model.early_discount;
            model.normal_discount = isEmpty(this.model.normal_discount) ? null : this.model.normal_discount;
            return axios[method](url, model)
              .then(({ data }) => {
                axios.get(`/api/suppliers/${data.data.id}`)
                  .then(({ data }) => {
                    this.fillModelWithData(data.data);
                  });
                this.changeEditMode(false);
                this.$toastr(
                  "success",
                  `Successfully ${msg}d Supplier`,
                  "Success!!"
                );
              })
              .catch(error => {
                this.$toastr("error", `Could not ${msg} Supplier`, "Error!!");
              })
              .finally(() => this.disableLoading());
            } else {
              this.$toastr("error", 'Please fill required fields.', "Error!!");
            }
        });
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
      fetchSuppliers(params) {
        this.enableLoading();
        getSuppliersReport({...DEFAULT_PARAMS, ...params})
          .then(({ data }) => {
            this.logs = data.data;
            this.pagination = data.meta;
          })
          .catch(error => console.log(error))
          .finally(() => this.disableLoading());
      },
      fetchSupplierIndex() {
        this.enableLoading();
        axios.get("/api/suppliers")
          .then(({ data }) => {
          if (data.data.id) {
            this.fetchSupplier(data.data.id);
          } else {
            this.$toastr('error', 'No records.', 'Error!!')
          }
        })
          .catch(error => console.log(error))
          .finally(this.disableLoading);
      },
      fetchSupplier(id) {
        this.enableLoading();
        axios.get(`/api/suppliers/${id}`).then(({ data }) => {
          this.fillModelWithData(data.data);
        })
          .catch(error => console.log(error))
          .finally(() => this.disableLoading());
      },
      fillModelWithData(supplier) {
        this.model = supplier;
        this.model.sales_detail = this.model.sales_detail || BASE_STATE.sales_detail;
        this.model.bank = this.model.bank || BASE_STATE.bank;
        this.model.early_discount = this.model.early_discount || BASE_STATE.early_discount;
        this.model.normal_discount = this.model.normal_discount || BASE_STATE.normal_discount;
        this.model.products = this.model.products || BASE_STATE.products;
        this.model.default_cost_account = this.model.default_cost_account || {};
        this.model.levy_account = this.model.levy_account || {};
        this.model.central_billing = this.model.central_billing || {};
        this.model.site = this.model.site || {};
        this.model.remittance_items = this.model.remittance_items || {};
      },
      enableEditMode() {
        this.modelCache = { ...this.model };
        this.changeEditMode(true);
      },
      changeEditMode(type) {
        this.isEditMode = !!type;
      },
      cancelEditMode() {
        this.model = this.modelCache;
        this.changeEditMode(false);
      },
      openModal(type) {
        this[`mount${type}`] = true;
      },
      closeModal(type) {
        this[`mount${type}`] = false;
      },
      createNewSupplier() {
        this.modelCache = {...this.model};
        this.model = {...BASE_STATE};
        this.changeEditMode(true);
      },
      selectNewState({ state, suburb, code }) {
        this.model.state = state;
        this.model.suburb = suburb;
        this.model.code = code;
      },
      validate() {
        return this.$validator.validate();
      },
    }
	}	
</script>

<style scoped>
.btn.active {
  background-color: cadetblue;
  box-shadow: none !important;
}
::-webkit-scrollbar {
    display: none;
}
</style>

