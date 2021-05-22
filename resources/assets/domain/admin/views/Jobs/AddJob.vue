<template></template>

<script>
import get from "lodash/fp/get";
import { isEmpty, formatViewDate, displayMoney, displayNumber } from "../../../common/utitlities/helpers";
import { BookingMixin, LoadingMixin, CurrentUserMixin } from "../../../common/mixins/index";
import PortletContent from "../../../common/components/Portlets/Content/PortletContent";
import Form from "../../../common/utitlities/Form";
import Modal from "../../../common/components/Modal/Modal";
import StateModal from "../../../common/components/StateModal";
import DropDown from "../../../common/components/DropDown/DropDown";
import Update from "./components/Update";
import EditRetention from "./components/EditRetention";
import AllocateMit from "./components/AllocateMIT";
import AllocateLabour from "./components/AllocateLabour";
import CreateInvoice from "./components/CreateInvoice";
import SelectShop from "./components/SelectShop";
import CreateReceipt from "./components/CreateReceipt";
import SelectProduct from "./components/SelectProduct";
import JobModal from "./components/JobModal";
import QuoteToJobInv from "./components/QuoteToJobInvoice";
import SearchJob from "./components/SearchJob";
import ForceJob from "./components/ForceJob";
import Page1 from '../Stocks/Page1'
import Page2 from '../Stocks/Page2'
import Page3 from '../Stocks/Page3'
import Page4 from '../Stocks/Page4'
import Page5 from '../Stocks/Page5'
import Page6 from '../Stocks/Page6'
import ActOnMaterial from './components/ActOnMaterial';
import TermsModal from '../../../common/components/TermsModal';
import StaffModal from "../../../common/components/StaffModal";
import EditMaterialProduct from '../../../common/components/EditMaterialProduct';
import EditLabourProduct from '../../../common/components/EditLabourProduct';
import { 
  getAccountsBySite,
  getNonAllocatedReceipts,
} from '../../api/calls';
import DeleteReceipt from '../../../common/components/DeleteReceipt';
import AddMemo from '../../views/Memos/components/AddMemo';
import { DETAIL } from '../../../common/const/AccountType';

const BASE_ADDRESS = { town: '', state: '', code: '', street: '' };

const BASE_ADD_STOCK = {
  interim_order_number: null,
  supplier_reference: '',
  delivery_address: {},
  supplier_details: {
    placed_with: '',
  },
  isEdit: false,
  show: false,
  values: {
    add_stock_id: null,
    quantity: null,
    unit: null,
    list_price: null,
    discount: null,
    delivery: null,
    tax: null,
    sell_price: null,
    delivery_date: '',
  },
};

const PAGE_TITLE = [
  'Add Stock Order Item',
  'Making Stock Order',
  'Placing Stock Order',
  'Delivery Address',
  "New Order - Supplier's Reference",
  'New Stock Order Placed'
];

export default {
  name: "AddJob",
  components: {
    CreateInvoice,
    CreateReceipt,
    PortletContent,
    Modal,
    DropDown,
    Update,
    SelectProduct,
    JobModal,
    QuoteToJobInv,
    SearchJob,
    StaffModal,
    ForceJob,
    StateModal,
    Page1,
    Page2,
    Page3,
    Page4,
    Page5,
    Page6,
    ActOnMaterial,
    TermsModal,
    EditRetention,
    AllocateMit,
    AllocateLabour,
    EditMaterialProduct,
    EditLabourProduct,
    DeleteReceipt,
    AddMemo,
    SelectShop
  },
  props: {
    products: {
      type: String,
      required: true
    },
    labourproducts: {
      type: String,
      required: true
    },
    url: {
      required: true,
      type: String
    },
    method: {
      required: true,
      type: String
    },
    job: {
      type: Object,
      default: () => {},
    },
    customers: {
      type: Array,
      required: false
    },
    redirecturl: {
      type: String,
      required: true
    },
    templates: {
      type: Array,
      default: () => []
    },
    bookingTypes: {
      type: Array,
      default: () => []
    },
    bookings: {
      type: Array,
      default: () => []
    },
    complaints: {
      type: Array,
      default: () => []
    },
    site: {
      type: Object,
      default: () => ({})
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
  mixins: [BookingMixin, LoadingMixin, CurrentUserMixin],
  data() {
    return {
      memos: [],
      selectedMitForDelete: {},
      accounts: [],
      selectedMaterialForActing: {},
      supplier: {},
      color: {},
      product: {},
      newStock: [],
      currentPageIndex: 0,
      pageList: [
        'Page1', 'Page2', 'Page3', 'Page4', 'Page5', 'Page6'
      ],
      selectedCustomTemplates: [],
      jobInvoiceReceiptInvoiceId: 0,
      jobInvoiceReceiptPage: 1,
      selectedSite: {},
      selectedShop: {},
      editMode: false,
      form: new Form(),
      mountStateModal: false,
      mountSelectShopModal: false,
      mountForceJob: false,
      mountStaffModal: false,
      mountSearchJob: false,
      mountQuoteToJobInv: false,
      mountProductModal: false,
      mountJobModal: false,
      mountUpdate: false,
      mountInvoice: false,
      mountReceipt: false,
      mountEditRetention: false,
      mountAllocateMIT: false,
      mountAllocateLabour: false,
      mountEditMaterialProduct: false,
      mountEditLabourProduct: false,
      mountDeleteReceipt: false,
      mountAddMemo: false,
      selectedMemoForEdit: {},
      loaded: true,
      formSubmitting: true,
      selectedSale: {},
      productVariants: [],
      page: 1,
      modals: {
        addStock: { ...BASE_ADD_STOCK },
        memo: {
          show: false,
          values: { user_id: "" }
        },
        invoice: { show: false, values: {} },
        newJob: {
          show: false
        }
      },
      customerDetails: {
        address: {}
      },
      showCustomerList: false,
      values: {
        customerDetails: {
          address: { ...BASE_ADDRESS },
          manual: false
        },
        commission_percentage: 0,
        guided_percentage: 0,
        quote_gst: 10,
        job: {
          customer_id: "",
          project: "",
          remarks: "",
          metadata: {},
          job_source_id: "",
          inclusive_total: 0,
          type: '',
          gst: '',
          calculated_total_sell: '',
          gst_inclusive_quote: '',
          term: {},
          quote_price: 0,
          costed_commission: 0,
          creditors_payables: [],
          contractors_payables: [],
          paid_payables: [],
          dispatches: [],
        },
        selectedSales: [],
        jobSource: "",
        material: {
          selectedVariant: "",
          selectedProduct: "",
          unitCost: 1,
          quantity: 1,
          variantName: ""
        },
        labour: {
          selectedVariant: "",
          selectedProduct: "",
          unitCost: 1,
          quantity: 1,
          variantName: ""
        },
        materials: [],
        labours: [],
        selectedTemplates: []
      },
      termData: this.term,
      invoices: [],
      nonAllocatedReceipts: [],
      receipts: [],
      jobSources: [],
      staffs: [],
      selectedJobSourceId: {},
      mountActOnMaterial: false,
      mountTermsModal: false,
      selectedStaff: {},
      salesCodeId: '',
      selectedMaterialProduct: {},
      selectedMaterialProductIndex: '',
      selectedLabourProduct: {},
    };
  },
  computed: {
    netLabourAllocated() {
      const value = this.values.job.paid_payables.reduce((carry, remitItem) => {
        return Number(carry) + (remitItem.payment_due_id ? Number(remitItem.net_payment) : 0);
      }, 0)

      return value.toFixed(2);
    },
    isEditMode() {
      return !!this.job.id;
    },
    salesCode() {
      return this.findSalesCode(this.salesCodeId);
    },
    selectedVariantIds() {
      if (!this.values.materials.length) {
        return [];
      }
      return this.values.materials.map(material => material.variant_id);
    },
    currentPage() {
      return this.pageList[this.currentPageIndex];
    },
    isFirstPage() {
      return this.currentPageIndex === 0;
    },
    isLastPage() {
      return this.currentPageIndex === (this.pageList.length - 1);
    },
    getPageData() {
      return this.modals.addStock;
    },
    getTitle() {
      return PAGE_TITLE[this.currentPageIndex];
    },
    gstInclusiveQuote() {
      const value = this.values.job.gst_inclusive_quote ? Number(this.values.job.gst_inclusive_quote) : 0.00;
      return value.toFixed(2);
    },
    totalBilledInvoice() {
      const value = this.invoices.reduce((sum, x) => {
        return Number(sum) + Number(x.amount);
      }, 0);
      return value.toFixed(2);
    },
    netInvoiced() {
      const value = this.invoices.reduce((sum, x) => {
        return Number(sum) + Number(x.net_invoice);
      }, 0);
      return value.toFixed(2);
    },
    marginToDate() {
      return this.netInvoiced;
    },
    quoteMargin() {
      const margin = this.values.job.quote_price - Number(this.totalCost);
      return margin.toFixed(2);
    },
    quoteMarkUp() {
      const value = (Number(this.quoteMargin) / Number(this.totalCost)) * 100;
      return value.toFixed(2);
    },
    quoteGrossProfit() {
      if (!this.values.job.quote_price || this.values.job.quote_price == 0) {
        return 0;
      }
      const value = (Number(this.quoteMargin) / this.values.job.quote_price) * 100;
      return value.toFixed(2);
    },
    quoteTerm() {
      return get('terms.quote', this.values.job.term);
    },
    balanceDueTotal() {
      const value = this.invoices.reduce((acc, invoice) => {
        return Number(acc) + Number(this.invoiceBalanceDue(invoice));
      }, 0);
      const totalBalanceDue = value - this.values.job.unbilled_retention_amount;
      return totalBalanceDue.toFixed(2);
    },
    receiptsTotal() {
      const value = this.invoices.reduce((acc, invoice) => {
        return Number(acc) + Number(this.receiptsSumAmount(invoice.receipts));
      }, 0);
      const receiptsTotalWithMIT = Number(value) + Number(this.nonAllocatedReceiptsSum);
      return Number(receiptsTotalWithMIT).toFixed(2);
    },
    retentionTotal() {
      const value = this.invoices.reduce((acc, invoice) => {
        return Number(acc) + Number(invoice.retention_amount);
      }, 0);
      const totalRetention = value + this.values.job.unbilled_retention_amount;
      return Number(totalRetention).toFixed(2);
    },
    nonAllocatedReceiptsSum() {
      if (Array.isArray(this.nonAllocatedReceipts)) {
        const value = this.nonAllocatedReceipts.reduce((sum, receipt) => {
          return Number(sum) + Number(receipt.amount);
        }, 0);
        return value.toFixed(2);
      }
      return '0.00';
    },
    /**
     * Calculate the product price.
     * @returns {number}
     */
    productPrice() {
      return this.values.material.quantity * this.values.material.unitCost;
    },
    /**
     * Calculate the product price.
     * @returns {number}
     */
    labourProductPrice() {
      const cost = this.values.labour.quantity * this.values.labour.unitCost;
      return cost.toFixed(2);
    },
    /**
     * Calculate the grand total.
     * @return {number}
     */
    materialGrandTotal() {
      return this.values.materials.reduce((acc, material) => {
        // console.log
        let cost = Number(material.unit) * Number(material.quantity);
        // if (this.model.gst) {
        //   cost = cost + ((cost * this.model.gst) / 100);
        // }
        if (material.levy) {
          cost = cost + ((cost * material.levy) / 100);
        }
        if (material.discount) {
          cost = cost - ((cost * material.discount) / 100);
        }
        return cost + acc;
      }, 0);
      // const materials = this.values.materials;
      // let sum = 0;
      // for (let material of materials) {
      //   let cost = material.total;
      //   // let cost = Number(material.unit) * Number(material.quantity);
      //   // if (material.levy) {
      //   //   cost = cost + ((cost * material.levy) / 100);
      //   // }
      //   // if (material.discount) {
      //   //   cost = cost - ((cost * material.discount) / 100);
      //   // }
      //   sum += Number(cost);
      // }

      // return sum.toFixed(2);
    },
    materialGrandTotalFirstPage() {
      const materials = this.values.materials;
      let sum = 0;
      for (let material of materials) {
        sum += Number(material.quantity) * Number(material.unit_sell || 0);
      }

      return sum;
    },
    materialLabourCostTotal() {
      const cost = Number(this.materialGrandTotalFirstPage) + Number(this.labourGrandTotal);
      return cost.toFixed(2);
    },
    /**
     * Calculate the grand total.
     * @return {number}
     */
    labourGrandTotal() {
      const labours = this.values.labours;
      let sum = 0;
      for (let labour of labours) {
        sum += parseFloat(labour.total);
      }

      return parseFloat(sum);
    },
    netQuotePrice() {
      const price = (100 * (Number(this.gstInclusiveQuote) - Number(this.totalBilledInvoice))) / (100 + Number(this.values.job.gst));
      return price.toFixed(2);
    },
    gstValue() {
      const value = (this.values.job.quote_price * Number(this.values.job.gst)) / 100;
      return value.toFixed(2);
    },
    /**
     * Calculate the net cost.
     */
    netCost() {
      const cost = Number(this.labourGrandTotal) + Number(this.materialGrandTotal);
      return cost.toFixed(2)
    },
    commissionAmount() {
      let { commission_percentage } = this.values;

      return this.netCost * (commission_percentage / 100);
    },
    guidedAmount() {
      let { guided_percentage } = this.values;

      const amount = (Number(this.totalCost) * (guided_percentage / 100)) + Number(this.totalCost);
      return amount.toFixed(2);
    },
    totalCost() {
      const cost = Number(this.netCost) + Number(this.values.job.costed_commission);
      return cost.toFixed(2)
    },
    costedCommission() {
      return this.netCost + this.commissionAmount;
    },
    selectedJobSource() {
      return (
        this.jobSources.find(
          jobSource => jobSource.id === this.values.job.job_source_id
        ) || {}
      );
    },
    calculatedGST() {
      if (!this.values.job || !this.values.job.inclusive_total) {
        return 0;
      }
      return (this.values.quote_gst/100) * this.values.job.inclusive_total;
    },
    calculatedNetPrice() {
      if (!this.values.job || !this.values.job.inclusive_total) {
        return 0;
      }
      return this.values.job.inclusive_total - this.calculatedGST;
    },
    totalCreditorsPayables() {
      return this.values.job.creditors_payables.reduce((carry, payable) => Number(carry) + Number(payable.expected_amount), 0);
    },
    totalContractorsPayables() {
      return this.values.job.contractors_payables.reduce((carry, payable) => carry + Number(payable.amount), 0);
    },
    totalPaidPayables() {
      return this.values.job.paid_payables.reduce((carry, payable) => carry + Number(payable.net_payment), 0);
    },
    totalStockDispatches() {
      return this.values.job.dispatches.reduce((carry, dispatch) => carry + Number(dispatch.total), 0);
    },
  },
  watch: {
    'values.job.gst': {
      handler: function (gst) {
        this.values.job.gst_amount = (this.values.job.quote_price * Number(gst)) / 100;
      }
    },
    // 'values.job.quote_price': {
    //   handler: function (price) {
    //     this.values.job.gst_amount = (this.values.job.quote_price * Number(this.values.job.gst)) / 100;
    //   }
    // },
    job: {
      handler: function(job) {
        if (isEmpty(job)) {
          return;
        }
        if (job.recently_converted) {
          this.openInvoiceModal();
        }
        this.fetchAccountsBySite(job.site_id);
        this.mapEditJobToValue(job);
      },
      immediate: true
    },
    selectedCustomTemplates: {
      handler: function(templates) {
        if (!isEmpty(templates)) {
          this.values.materials = templates.material_products;
          this.values.labours = templates.labour_products;
        }
      },
      immediate: true
    }
  },
  created() {
    const urlParams = new URLSearchParams(window.location.search)
    if (urlParams.has('page')) {
      this.page = Number(urlParams.get('page'));
    }

    axios.get('/api/suppliers');
    if (this.job && this.job.id) {
      this.fetchNonAllocatedReceipts();
      this.getInvoices();
    }
  },
  methods: {
    formatViewDate,
    displayMoney,
    displayNumber,
    memoSaved() {
      this.refreshJobPage();
    },
    editMemoModal(memo) {
      this.selectedMemoForEdit = {...memo};
      this.mountAddMemo = true;
    }, 
    closeAddMemoModal() {
      this.selectedMemoForEdit = {};
      this.mountAddMemo = false;
    },
    receiptDeleted() {
      this.refreshJobPage();
    },
    openDeleteReceiptModal(receipt) {
      this.openModal('DeleteReceipt');
      this.selectedMitForDelete = { ...receipt };
    },
    getMaterialTotalFirstPage(material) {
      const cost = Number(material.quantity) * Number(material.unit_sell || 0);
      return cost.toFixed(2 || 0);
    },
    handleMaterialProductEdit(product) {
      for (var i in this.values.materials) {
        if (this.selectedMaterialProductIndex == i) {
            this.values.materials[i].discount = product.discount;
            this.values.materials[i].gst = product.gst;
            this.values.materials[i].levy = product.levy;
            this.values.materials[i].quantity = product.quantity;
            this.values.materials[i].total = product.total;
            this.values.materials[i].unit = product.unit;
            this.values.materials[i].sell_price = product.sell_price;
            this.values.materials[i].unit_sell = product.unit_sell;
            break;
          }
      }
    },
    handleLabourProductEdit(labour) {
      for (var i in this.values.labours) {
        if (this.selectedLabourProduct.product === this.values.labours[i].product) {
            this.values.labours[i].product = labour.product;
            this.values.labours[i].quantity = labour.quantity;
            this.values.labours[i].unit = labour.unit;
            this.values.labours[i].charge = labour.charge;
            this.values.labours[i].total = labour.total;
            this.values.labours[i].gst = labour.gst;
            break;
          }
      }
    },
    openEditMaterialProductModal(material, index) {
      this.selectedMaterialProduct = { ...material };
      this.selectedMaterialProductIndex = index;
      this.openModal('EditMaterialProduct');
    },
    openEditLabourProductModal(material) {
      this.selectedLabourProduct = { ...material };
      this.openModal('EditLabourProduct');
    },
    findSalesCode(accountId) {
      return this.accounts.find((account) => account.id === accountId) || {};
    },
    fetchAccountsBySite(siteId) {
      this.enableLoading();
      getAccountsBySite(siteId, {type: DETAIL})
        .then(({ data }) => {
          this.accounts = data.data;
        })
        .catch(() => {
          console.log('could not fetch accounts');
        })
        .finally(this.disableLoading);
    },
    calculate() {
      const gstInclusiveQuote = Number(this.values.job.quote_price) + Number(this.values.job.gst_amount);
      this.values.job.gst_inclusive_quote = gstInclusiveQuote.toFixed(2);
    },
    canAct(material) {
      if (!material.product_act_on_me) {
        return false;
      }
      return Number(this.calculateActOn(material)) > 0;
    },
    mediaButton(action) {
      if (action === 'prev' && this.previous) {
        window.location.href = `/jobs/${this.previous}/edit`
      }
      if (action === 'next' && this.next) {
        window.location.href = `/jobs/${this.next}/edit`
      }
    },
    creditorsPayableToChequeButt(remitItem) {
      window.location.href = `/cheque-butt?remittance=${remitItem.remittance_id}`;
    },
    creditorsPayableToPayable(payable) {
      window.location.href = `/payables?payable=${payable.id}`;
    },
    contractorsPayableToContractor(payable) {
      window.location.href = `/contractors/${payable.contractor.id}/edit`;
    },
    redirectToBilling(invoice) {
      window.location.href = `/billings?invoice=${invoice.id}`;
    },
    redirectToCurrentOrders(currentOrderId) {
      window.location.href = `/current-orders/${currentOrderId}`;
    },
    redirectToBooking(booking) {
      window.location.href = `/bookings?booking_type=${booking.booking_type_id}`
    },
    redirectToInstallationComplaint(complaint) {
      window.location.href =  `/installation-complaints/${complaint.id}/edit`
    },
    editSalesStaff(sale, index) {
      this.selectedStaff = { ...sale, index };
      this.openModal('StaffModal');
    },
    closeStaffModalHandler() {
      this.selectedStaff = {};
      this.closeModal('StaffModal')
    },
    handleTermUpdate(term) {
      this.values.job.term = term;
    },
    dispatchToStockHistory(dispatch) {
      console.log(dispatch);
      if (!dispatch.variant_id) {
        return;
      }
      window.location.href = `/color/${dispatch.variant_id}/stocks?page=2`
    },
    orderFutureStockForJob() {
      this.mountActOnMaterial = false;
      this.supplier = { 
        trading_name: this.selectedMaterialForActing.supplier_name,
        site: this.selectedMaterialForActing.site,
      };
      this.product = { name: this.selectedMaterialForActing.product_name };
      this.color = { name: this.selectedMaterialForActing.variant_name };
      this.modals.addStock.values.quantity = Number(this.selectedMaterialForActing.quantity) - Number(this.selectedMaterialForActing.allocated) - Number(this.selectedMaterialForActing.dispatched);
      this.modals.addStock.values.list_price = this.selectedMaterialForActing.unit;
      this.modals.addStock.values.discount = this.selectedMaterialForActing.discount;
      this.modals.addStock.values.tax = this.selectedMaterialForActing.gst;
      this.modals.addStock.values.levy = this.selectedMaterialForActing.levy;
      this.modals.addStock.values.delivery = this.selectedMaterialForActing.delivery;
      this.modals.addStock.show = true;
    },
    calculateActOn(material) {
      const amt = Number(material.quantity) - Number(material.allocated) - Number(material.dispatched);
      return amt.toFixed(2);
    },
    allocationOrBackOrderTOStock(colorId) {
      window.location.href = `/color/${colorId}/stocks`;
    },
    goPrevPage() {
      this.currentPageIndex = this.currentPageIndex - 1;
    },
    getFormattedDataForOrderStock() {
      return {
        futureStocks: [...this.newStock],
        supplier_details: this.modals.addStock.supplier_details,
        delivery_address: this.modals.addStock.delivery_address || {},
        supplier_reference: this.modals.addStock.supplier_reference,
        interim_order_number: this.modals.addStock.interim_order_number,
      };
    },
    saveFutureStock() {
      this.enableLoading();
      this.modals.addStock.show = false;
      const payload = this.getFormattedDataForOrderStock();
      axios.post(`/api/color/${this.selectedMaterialForActing.variant_id}/order-stock-from-job/${this.selectedMaterialForActing.id}`, payload)
        .then(({ data }) => {
          this.$toastr('success', data.message, 'Success!!');
          window.location.href = `/jobs/${this.job.id}/edit?page=2`
        })
        .catch((data) => {
          this.$toastr('error', data.message, 'Error!!')
        })
        .finally(this.disableLoading);
    },
    refreshJobPage(page = 3) {
      window.location.href = `/jobs/${this.job.id}/edit?page=${page}`;
    },
    goNextPage() {
      if(this.currentPageIndex === 1) {
        this.storeStockData();
      }
      this.currentPageIndex = this.currentPageIndex + 1;
    },
    goNextPageHandler() {
      this.$refs.dynamicComponent.$validator.validateAll()
        .then(valid => {
          if(valid) {
            this.goNextPage();
          }
        });
    },
    storeStockData() {
      // @TODO: set job_material_id for multiple future stocks while adding items to order on page 3
      this.newStock.push({ ...this.modals.addStock.values, job_material_id: this.selectedMaterialForActing.id });
      this.modals.addStock.values = {
        add_stock_id: null,
        quantity: null,
        unit: null,
        list_price: null,
        discount: null,
        delivery: null,
        tax: null,
        sell_price: null,
        delivery_date: '',
      };
    },
    addNewItemHandler() {
      this.currentPageIndex = 0;
    },
    valuesUpdateHandler(key, data) {
      this.modals.addStock[key] = data;
    },
    stockDataUpdateHandler(stockData) {
      this.modals.addStock.values = stockData;
    },
    setCurrentPage(index) {
      this.currentPageIndex = index;
    },
    handleStockItemModalClose() {
      this.modals.addStock = { ...BASE_ADD_STOCK };
      this.newStock = [];
      this.setCurrentPage(0);
    },
    openActModal(material) {
      this.selectedMaterialForActing = { ...material };
      this.mountActOnMaterial = true;
    },
    closeActModal() {
      this.mountActOnMaterial = false;
    },
    selectNewState({ state, suburb, code }) {
      if (this.values.customerDetails) {
        this.values.customerDetails.address.state = state;
        this.values.customerDetails.address.town = suburb;
        this.values.customerDetails.address.code = code;
      }
    },
    materialTotal(material) {
      const listCost = material.product_list_price ? Number(material.product_list_price) : 0;
      const quantity = material.quantity ? Number(material.quantity) : 0;
      const discount = material.product_discount ? Number(material.product_discount) : 0;
      const levy = material.product_levy ? Number(material.product_levy) : 0;
      const gst = material.product_gst ? Number(material.product_gst) : 0;
      let cost = listCost * quantity;
      if (gst) {
        cost = cost + ((cost * gst) / 100);
      }
      if (levy) {
        cost = cost + ((cost * levy) / 100);
      }
      if (discount) {
        cost = cost - ((cost * discount) / 100);
      }
      return Number(cost).toFixed(2);
    },
    openJobReceiptModal(invoiceId) {
      this.getInvoices();
      this.jobInvoiceReceiptPage = 2;
      this.jobInvoiceReceiptInvoiceId = invoiceId;
      this.updateModalStatus("Receipt", true);
    },
    openInvoiceModal() {
      this.openQuoteToJobInv();
    },
    addJobData(data) {
      axios
        .post("/api/mergedtemplates", data.templates)
        .then(({ data: tempData }) => {
          this.selectedCustomTemplates = tempData.data;
          this.values.job.type = this.selectedCustomTemplates.name;
          this.values.job.remarks = this.selectedCustomTemplates.remarks;
          this.values.guided_percentage = this.selectedCustomTemplates.guided_percentage;
          this.salesCodeId = this.selectedCustomTemplates.sales_code_id;
        })
        .catch(error => {
          console.log("could not fetch tempates");
        });
      if (data.terms_id) {
        // const term = this.terms.find(term => term.id == id);
      }
      this.values.customerDetails.manual = !data.client_id;
      if (data.client_id) {
        this.values.job.customer_id = data.client_id;
        this.handleCustomerSelect(data.client_id);
      }
      if (data.store_id) {
        this.fetchSite(data.store_id)
          .then(() => {
            if (data.shop_id) {
              this.selectedShop = this.selectedSite.shops.find(shop => {
                return data.shop_id === shop.id;
              })
            }
            this.values.job.gst = this.selectedSite.gst;
            this.values.job.gst_amount = 0;
          });
        this.fetchJobSourcesAndSalesStaff(data.store_id);
      }

      this.values.job.term = data.term;
      this.values.job.quote_date = data.quote_date;
      this.values.job.job_source_id = data.source_id;
      this.values.job.shop_id = data.shop_id;
      this.selectedJobSourceId = this.findJobSource(data.source_id);
      this.setSelectedSalesStaffs(data.sales_person, data.primary_rep);
    },
    setSelectedSalesStaffs(salesStaffs, primaryRep = "") {
      const length = salesStaffs.length;
      this.values.selectedSales = salesStaffs.map(staff => {
        return {
          sales_id: staff,
          priority:
            primaryRep === staff || primaryRep === "" ? "primary" : "secondary",
          commission: 100 / length
        };
      });
    },
    setDefaultSelectedJobSource(data) {
      if (data) {
        this.values.job.job_source_id = data;
        this.selectedJobSourceId = this.findJobSource(data);
      }
    },
    findJobSource(id) {
      return this.jobSources.find(jobSource => jobSource.id === id);
    },
    fetchSite(id) {
      return axios.get(`/api/sites/${id}`).then(({ data }) => {
        this.selectedSite = data.data;
      });
    },
    fetchJobSourcesAndSalesStaff(id) {
      if (id) {
        Promise.all[(
          this.fetchJobSources(id), 
          this.fetchSalesStaff(id),
          this.fetchAccountsBySite(id)
        )];
      }
    },
    fetchJobSources(id) {
      return axios.get(`/api/sites/${id}/sources`).then(({ data }) => {
        this.jobSources = data.data;
      });
    },
    fetchSalesStaff(id) {
      return axios.get(`/api/sites/${id}/sales_staff`).then(({ data }) => {
        this.staffs = data.data;
      })
      .catch(() => {
        console.log('could not fetc');
      });
    },
    fetchNonAllocatedReceipts() {
      getNonAllocatedReceipts(this.job.id)
        .then(({ data }) => {
          this.nonAllocatedReceipts = data.data;
        })
        .catch(() => {
          console.log('could not fetch mit payments.');
        });
    },
    getInvoices() {
      axios.get(`/jobs/${this.job.id}/invoices`)
        .then(({ data }) => {
          this.invoices = data.data;
        })
        .catch(() => {
          console.log('could not fetc');
        });
    },
    updateModalStatus(type, status) {
      this[`mount${type}`] = !!status;
    },
    invoiceBalanceDue(invoice) {
      const { amount, receipts, expenses, retention_amount } = invoice;
      const receiptAmt = this.receiptsSumAmount(receipts);
      const invBalance = Number(amount) - receiptAmt;
      const expenseAmt = this.expensesSumAmount(expenses);
      const netBalance = Number(invBalance) - Number(expenseAmt);
      const afterRetention = Number(netBalance) - Number(retention_amount);
      return Number(afterRetention).toFixed(2);
    },
    receiptsSumAmount(receipts) {
      return receipts.reduce((acc, receipt) => Number(receipt.amount) + Number(acc), 0);
    },
    expensesSumAmount(expenses) {
      return expenses.reduce((acc, expense) => Number(expense.net_amount) + Number(acc), 0);
    },
    /**
     * Proceed towards the form submission.
     *  */
    submit() {
      let {
        commission_percentage,
        guided_percentage,
        quote_gst,
        notes
      } = this.values;
      this.values.job.commission = {
        commission_percentage,
        guided_percentage,
        quote_gst,
        notes
      };
      this.values.job.labour = this.values.labours;
      this.values.job.site_id = this.selectedSite.id;
      this.values.job.material_total = this.materialGrandTotal;
      this.values.job.labour_total = this.labourGrandTotal;
      this.values.job.net_cost = this.netCost;
      this.values.job.total_cost = this.totalCost;
      this.values.job.margin = Number(this.quoteMargin);
      this.values.job.markup = this.quoteMarkUp;
      this.values.job.gp = this.quoteGrossProfit;
      this.calculate();
      this.form = new Form(this.values);
      const currentPage = this.page;
      $("html, body").animate({ scrollTop: 0 }, "slow");
      this.form
        .onSubmit(this.method, this.url)
        .then(response => {
          this.$toastr("success", this.form.alertMessage, "Success!!");
          if (this.job) {
            this.refreshJobPage(currentPage);
          } else {
            window.location.href = this.redirecturl;
          }
          
        })
        .catch(errors => {
          this.$toastr("error", this.form.alertMessage, "Error!!");
        });
    },
    /**
     * Map quote value on edit.
     * @param {Object} job
     * */
    mapEditJobToValue(job) {
      this.selectedSite = { ...job.site };
      this.selectedShop = { ...job.shop };
      this.fetchJobSourcesAndSalesStaff(this.selectedSite.id);

      let {
        customer_id,
        project,
        remarks,
        metadata,
        job_source_id,
        commission,
        labour,
        type,
        gst,
        gst_amount,
        gst_inclusive_quote,
        term,
        address,
        title,
        firstname,
        trading_name,
        contact,
        phone,
        work_phone,
        email,
        fax,
        mobile,
        unbilled_retention_amount,
        unbilled_retention_release_date,
        costed_commission,
        quote_price,
        sales_code_id,
        guided_percentage,
        quote_date,
        initiation_date,
        job_id,
        memo_references,
        costed_commission_paid,
        costed_commission_date_paid,
        costed_commission_balance,
        costed_commission_text,
        completed_percent,
        completed_on,
        financed,
        approved_date,
        approval_code,
        allocations_and_back_orders,
        future_stocks,
        dispatches,
        creditors_payables,
        contractors_payables,
        paid_payables
      } = job;

      this.values.customerDetails.address = address || {};
      this.values.customerDetails.title = title;
      this.values.customerDetails.firstname = firstname;
      this.values.customerDetails.trading_name = trading_name;
      this.values.customerDetails.contact = contact;
      this.values.customerDetails.phone = phone;
      this.values.customerDetails.work_phone = work_phone;
      this.values.customerDetails.email = email;
      this.values.customerDetails.fax = fax;
      this.values.customerDetails.mobile = mobile;

      this.values.job = {
        customer_id,
        project,
        remarks,
        metadata,
        job_source_id,
        type,
        gst,
        gst_amount,
        gst_inclusive_quote,
        term: term ? term : {},
        unbilled_retention_amount,
        unbilled_retention_release_date,
        costed_commission,
        quote_price,
        guided_percentage,
        quote_date,
        initiation_date,
        job_id,
        costed_commission_paid,
        costed_commission_date_paid,
        costed_commission_balance,
        costed_commission_text,
        completed_percent,
        completed_on,
        financed,
        approved_date,
        approval_code,
        allocations_and_back_orders,
        future_stocks,
        dispatches,
        creditors_payables,
        contractors_payables,
        paid_payables
      };

      this.salesCodeId = sales_code_id;
      this.selectedJobSourceId = this.findJobSource(job_source_id);
      this.memos = memo_references;

      if (job.commission !== null) {
        const {
          commission_percentage,
          guided_percentage,
          quote_gst,
          notes
        } = commission;
        this.values.commission_percentage = commission_percentage;
        this.values.guided_percentage = guided_percentage;
        this.values.quote_gst = quote_gst;
        this.values.notes = notes;
      } else {
        this.values.commission_percentage = 0;
        this.values.guided_percentage = 0;
        this.values.quote_gst = 0;
      }

      let materialSalesPrice = job.materials;

      materialSalesPrice = materialSalesPrice.map(materialSale => ({
        id: materialSale.id,
        material_from: materialSale.material_from,
        product_act_on_me: materialSale.product ? materialSale.product.act_on_me : false,
        product_id: materialSale.product ? materialSale.product.id : null,
        supplier_id: materialSale.supplier ? materialSale.supplier.id : materialSale.product.supplier.id,
        site: materialSale.supplier ? materialSale.supplier.site : {},
        product_name: materialSale.product ? materialSale.product.name : 'Bailing/Delivery',
        product_upc: materialSale.product ? `${materialSale.product.supplier_id} - ${materialSale.product.upc || materialSale.product.id}` : "",
        upc: materialSale.product ? `${materialSale.product.upc || materialSale.product.id}` : "",
        supplier_name: materialSale.supplier ? materialSale.supplier.trading_name : materialSale.product.supplier.trading_name,
        variant_name: materialSale.variant ? materialSale.variant.name : "",
        variant_id: materialSale.variant ? materialSale.variant.id : null,
        unit: materialSale.unit || 0.00,
        unit_sell: materialSale.unit_sell || 0.00,
        quantity: materialSale.quantity,
        total: materialSale.total,
        on_order: materialSale.on_order,
        allocated: materialSale.allocated,
        dispatched: materialSale.dispatched,
        act_on: materialSale.act_on,
        gst: materialSale.gst,
        levy: materialSale.levy,
        discount: materialSale.discount,
        delivery: materialSale.supplier ? materialSale.supplier.delivery : '',
      }));
      this.values.materials = materialSalesPrice;

      this.values.labours = labour;
      // let labourSalesPrice = job.labour_sales_price
      // labourSalesPrice = labourSalesPrice.map((labourSale) => ({
      //   product: labourSale.name,
      //   labour_product_id: labourSale.id,
      //   quantity: labourSale.pivot.quantity,
      //   unit: labourSale.pivot.unit,
      //   total: labourSale.pivot.total,
      // }))
      // this.values.labours = labourSalesPrice

      this.values.selectedSales = job.sales.map(sale => {
        return {
          sales_id: sale.pivot.sales_id,
          priority: sale.pivot.priority,
          commission: sale.pivot.commission
        };
      });
    },
    /**
     * Load the data to the form.
     */
    loadCustomer(customer) {
      this.values.job.customer_id = customer.id;
      this.values.customerDetails = customer;
      this.values.customerDetails.address = Array.isArray(customer.address) ? BASE_ADDRESS : { ...BASE_ADDRESS, ...customer.address };
    },
    /**
     * Handles the product select event.
     * @param {String} productId
     * */
    handleProductSelect(productId) {
      this.productVariants = [];
      this.values.material.selectedVariant = "";
      this.values.material.unitCost = 0;
      this.values.material.quantity = 1;

      if (productId !== "") {
        let product = this.getProductById(productId);
        this.values.material.unitCost = product.list_cost || 1;
        this.productVariants = product.product_variants;
      }
    },
    getProductById(id) {
      return JSON.parse(this.products).find(product => product.id === id) || {};
    },
    getLabourById(id) {
      return (
        JSON.parse(this.labourproducts).find(product => product.id === id) || {}
      );
    },
    getProductVariantById(id) {
      return this.productVariants.find(product => product.id === id) || {};
    },
    /**
     * Handles the product select event.
     * @param {String} productId
     * */
    handleLabourProductSelect(productId) {
      this.values.labour.selectedVariant = "";
      this.values.labour.unitCost = 0;
      this.values.labour.quantity = 1;

      if (productId !== "") {
        let product = this.getLabourById(productId);
        this.values.labour.unitCost = product.unit_cost;
      }
    },
    /**
     * Handle variant select event.
     * **/
    handleVariantSelect(id) {
      let variant = this.getProductVariantById(id);
      this.values.material.variantName = variant.name;
    },
    /**
     * Add job sources.
     */
    addJobSources() {
      if (
        this.selectedJob &&
        !this.values.selectedJobs.includes(this.selectedJob)
      ) {
        this.values.selectedJobs.push(this.selectedJob);
        this.selectedJob = "";
      }
    },
    /**
     * Remove the job sources from the selected list.
     * @param index
     */
    removeJobSource(index) {
      this.values.selectedJobs.splice(index, 1);
    },
    /**
     * Add job sources.
     */
    addSalesStaff(selectedSale) {
      if (
        !selectedSale.sales_id ||
        !selectedSale.priority ||
        !selectedSale.commission ||
        !!this.values.selectedSales.find(
          sale => sale.sales_id === selectedSale.sales_id
        )
      ) {
        return false;
      }
      const totalCommission = this.values.selectedSales.reduce((sum, sale) => {
        return sum + Number(sale.commission);
      }, 0);
      if (Number(totalCommission) + Number(selectedSale.commission) > 100) {
        return false;
      }
      if (
        selectedSale.priority === "primary" &&
        !!this.values.selectedSales.find(sale => sale.priority === "primary")
      ) {
        return false;
      }
      this.values.selectedSales.push(selectedSale);
    },
    updateSalesStaff({ selectedSale, index }) {
      if (
        !selectedSale.sales_id ||
        !selectedSale.priority ||
        !selectedSale.commission ||
        !Number.isInteger(index)
      ) {
        return false;
      }

      this.$set(this.values.selectedSales, Number(index), selectedSale);
    },
    /**
     * Remove the job sources from the selected list.
     * @param salesId
     */
    removeSalesStaff(salesId) {
      const salesStaffIndex = this.values.selectedSales.findIndex(
        sale => sale.sales_id === salesId
      );
      this.values.selectedSales.splice(salesStaffIndex, 1);
    },
    /**
     * Get the sales full name when id is provided.
     * @param id
     * @returns {*}
     */
    getSalesName(id) {
      const sale = this.staffs.find(sale => sale.id === id) || {};
      return sale.name;
    },
    /**
     * Remove the site when index is provided.
     * @param {int} index
     * @param {Object} site
     */
    removeSite(index, site) {
      if (site.hasOwnProperty("id")) {
        this.values.deletedSites.push(site.id);
      }
      this.values.sites.splice(index, 1);
    },
    /**
     * Add new material.
     */
    addNewMaterial() {
      let materialCollection = this.values.materials;
      let exists = false;
      materialCollection.forEach(material => {
        if (
          material.product_id == this.values.material.selectedProduct &&
          material.variant_id == this.values.material.selectedVariant
        ) {
          exists = true;
          return;
        }
      });

      if (
        this.values.material.selectedProduct !== "" &&
        this.values.material.selectedVariant !== "" &&
        !exists
      ) {
        let material = {
          product_name: this.getProductName(
            this.values.material.selectedProduct
          ),
          product_id: this.values.material.selectedProduct,
          variant_name: this.values.material.variantName,
          variant_id: this.values.material.selectedVariant,
          quantity: this.values.material.quantity,
          unit: this.values.material.unitCost
        };
        material.total = Number(this.values.material.quantity) * Number(this.values.material.unitCost);
        this.values.materials.push(material);

        this.values.material = {
          selectedVariant: "",
          selectedProduct: "",
          unitCost: 1,
          quantity: 1,
          variantName: ""
        };
      }
    },
    /**
     * Add new material.
     */
    addNewLabour() {
      let labour = {
        product: this.values.labour.product,
        quantity: this.values.labour.quantity,
        unit: this.values.labour.unitCost
      };
      labour.total = this.labourProductPrice;

      this.values.labours.push(labour);

      this.values.labour = {
        unitCost: 1,
        quantity: 1,
        variantName: ""
      };
    },
    /**
     * Remove material from added materials list with given index.
     * @param {Number} index
     */
    removeMaterial(index) {
      this.values.materials.splice(index, 1);
    },
    /**
     * Remove material from added materials list with given index.
     * @param {Number} index
     */
    removeLabour(index) {
      this.values.labours.splice(index, 1);
    },
    /**
     * Generate product name from product id.
     * @param {Number} productId
     * @return {String}
     */
    getProductName(productId) {
      return this.getProductById(productId).name;
    },
    /**
     * Generate labour product name from product id.
     * @param {Number} productId
     * @return {String}
     */
    getLabourProductName(productId) {
      return this.getLabourById(productId).name;
    },
    /**
     * Handle customer select.
     * @param {Number} customerId
     * */
    handleCustomerSelect(customerId) {
      if (customerId == "") {
        this.customerSelected = false;
        this.values.customerDetails = {
          address: { ...BASE_ADDRESS }
        };
      } else {
        axios
          .get(`/api/clients/${customerId}`)
          .then(response => {
            this.showCustomerList = false;
            this.values.customerDetails = response.data.data;
            this.values.customerDetails.address =
              response.data.data.address || { ...BASE_ADDRESS };
          })
          .catch(error => {
            this.showCustomerList = true;
          });
      }
    },
    /**
     * Proceed to the job creation page.
     * */
    proceedJobCreatePage() {
      location.href = `/jobs/create?templates=${this.values.selectedTemplates}`;
    },
    /**
     * Create a memo
     * **/
    createMemo() {
      let { values } = this.modals.memo;
      values.reference_id = this.job.id;
      values.type = "job";
      this.form = new Form(values);
      $("html, body").animate({ scrollTop: 0 }, "slow");
      this.form
        .onSubmit("post", `/memos`)
        .then(response => {
          this.$toastr("success", this.form.alertMessage, "Success!!");
          location.reload();
        })
        .catch(errors => {
          this.$toastr("error", this.form.alertMessage, "Error!!");
        });
    },
    addNewInvoice() {
      let { values } = this.modals.invoice;
      values.job_id = this.job.id;
      this.form = new Form(values);
      this.form
        .onSubmit("post", `invoice`)
        .then(response => {
          this.$toastr("success", this.form.alertMessage, "Success!!");
          location.reload();
        })
        .catch(errors => {
          this.$toastr("error", this.form.alertMessage, "Error!!");
        });
    },
    showAddBookingModal() {
      const bookingModal = this.modals.newBooking;
      bookingModal.values.job_id = this.job.job_id;
      bookingModal.values.customer = this.job.trading_name;
      bookingModal.values.site_id = this.job.site_id;
      bookingModal.values.location = this.job.address ? this.job.address.town : '';
      bookingModal.show = true;
    },
    addComplaint() {
      location.href = `/installation-complaints/create?job=${this.job.id}`;
    },
    openProductModal() {
      this.mountProductModal = true;
    },
    closeProductModal() {
      this.mountProductModal = false;
    },
    handleProductAdd(product) {
      this.values.materials.push(product);
    },
    openJobModal() {
      this.mountJobModal = true;
    },
    closeJobModal() {
      this.mountJobModal = false;
    },
    openQuoteToJobInv() {
      this.mountQuoteToJobInv = true;
    },
    closeQuoteToJobInv() {
      this.mountQuoteToJobInv = false;
    },
    addQuoteData(data) {
      console.log(data);
    },
    closeSearchJob() {
      this.mountSearchJob = false;
    },
    openSearchJob() {
      this.mountSearchJob = true;
    },
    openModal(type) {
      this[`mount${type}`] = true;
    },
    closeModal(type) {
      this[`mount${type}`] = false;
    },
    handleForcedPrice(forcedPrice) {
      this.values.job.gst_inclusive_quote = forcedPrice;
      const price = (100 * Number(forcedPrice)) / (100 + Number(this.values.job.gst));
      const netQuotePrice = price.toFixed(2);
      this.values.job.quote_price = netQuotePrice;
      const gstAmount = forcedPrice - Number(netQuotePrice);
      this.values.job.gst_amount = gstAmount.toFixed(2);
    },
  }
};
</script>

<style lang="scss">
::-webkit-scrollbar {
    display: none;
}

.job-small-text {
  font-size: 60%;
  font-weight: 400;
}

.m-portlet {
  .m-portlet__head {
    padding: 0 1rem;
  }

  .m-portlet__body {
    padding: 1rem 1rem;
  }
}

.table th,
.table td {
  vertical-align: middle;
}

.mt-28 {
  margin-top: 28px;
}

.currentPage {
  color: yellow !important;
  background: #848284;
}

.commissionInput {
  height: 1.5em;
}

.invoice-receipts__block {
  max-height: 360px;
  overflow-y: auto;
}

.background-black {
  background-color: black;
  color: white;
  width: fit-content;
  padding: 3px;
}

.ml-11 {
  margin-left: 11px !important;
}

// .inputWithDollar {
  
// }
@media (max-width: 600px) {
  .inputWithDollar {
    margin-left: -24px; 
    width: 145px
  }
} 
@media (min-width: 700px) {
  .inputWithDollar {
    margin-left: -10px; 
    width: 145px
  }
}
@media (min-width: 800px) {
  .inputWithDollar {
    margin-left: -12px; 
    width: 145px
  }
}
@media (min-width: 900px) {
  .inputWithDollar {
    margin-left: -14px; 
    width: 145px
  }
}

@media (min-width: 1000px) {
  .inputWithDollar {
    margin-left: -17px; 
    width: 145px
  }
}

@media (min-width: 1100px) {
  .inputWithDollar {
    margin-left: -19px; 
    width: 145px
  }
}

@media (min-width: 1200px) {
  .inputWithDollar {
    margin-left: -22px; 
    width: 145px
  }
}

@media (min-width: 1300px) {
  .inputWithDollar {
    margin-left: -25px; 
    width: 145px
  }
}

@media (min-width: 1400px) {
  .inputWithDollar {
    margin-left: -27px; 
    width: 145px
  }
}

@media (min-width: 1500px) {
  .inputWithDollar {
    margin-left: -28px; 
    width: 145px
  }
}

@media (min-width: 1600px) {
  .inputWithDollar {
    margin-left: -31px; 
    width: 145px
  }
}

@media (min-width: 1700px) {
  .inputWithDollar {
    margin-left: -33px; 
    width: 145px
  }
}

@media (min-width: 1800px) {
  .inputWithDollar {
    margin-left: -37px; 
    width: 145px
  }
}
@media (min-width: 1900px) {
  .inputWithDollar {
    margin-left: -39px; 
    width: 145px
  }
}
@media (min-width: 2000px) {
  .inputWithDollar {
    margin-left: -41px; 
    width: 145px
  }
}

.dollarLabelBeforTextBox {
  font-size: 12px !important;
}

.jobCalculationInputField {
  margin-top: -1px;
}
</style>
