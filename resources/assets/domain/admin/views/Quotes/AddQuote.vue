<template></template>

<script>
import get from "lodash/fp/get";
import AddMemo from '../../views/Memos/components/AddMemo';
import { 
  isEmpty, 
  formatViewDate, 
  displayMoney, 
  displayNumber 
} from "../../../common/utitlities/helpers";
import { BookingMixin, LoadingMixin, CurrentUserMixin } from "../../../common/mixins/index";
import PortletContent from "../../../common/components/Portlets/Content/PortletContent";
import Form from "../../../common/utitlities/Form";
import Modal from "../../../common/components/Modal/Modal";
import StateModal from "../../../common/components/StateModal";
import DropDown from "../../../common/components/DropDown/DropDown";
import SelectProduct from "../Jobs/components/SelectProduct";
import QuoteModal from "./components/QuoteModal";
import UpdateQuoteModal from "./components/UpdateQuoteModal";
import SearchQuote from "./components/SearchQuote";
import ForceQuote from "./components/ForceQuote";
import StaffModal from "../../../common/components/StaffModal";
import TermsModal from '../../../common/components/TermsModal';
import EditMaterialProduct from '../../../common/components/EditMaterialProduct';
import EditLabourProduct from '../../../common/components/EditLabourProduct';
import { getAccountsBySite } from '../../api/calls';

let currentDate = new Date().toISOString().split("T")[0];
const BASE_ADDRESS = { town: '', state: '', code: '', street: '' };

export default {
  name: "AddQuote",
  mixins: [BookingMixin, LoadingMixin, CurrentUserMixin],
  components: {
    DropDown,
    PortletContent,
    Modal,
    SelectProduct,
    UpdateQuoteModal,
    QuoteModal,
    StaffModal,
    SearchQuote,
    ForceQuote,
    StateModal,
    TermsModal,
    EditLabourProduct,
    EditMaterialProduct,
    AddMemo,
  },
  props: {
    customer: { type: Object, required: false },
    products: { type: String, required: true },
    labourproducts: { type: String, required: true },
    url: { required: true, type: String },
    method: { required: true, type: String },
    // jobsources: { required: true, type: String },
    quote: {
      type: Object,
      default: () => ({})
    },
    customers: { type: Array, required: false },
    redirecturl: { type: String, required: true },
    // staffs: { type: Array, required: false },
    templates: { type: Array, required: false, default: () => [] },
    // selectedCustomTemplates: {
    //   type: Object,
    //   required: false,
    //   default: () => ({})
    // },
    bookingTypes: {
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
  data() {
    return {
      accounts: [],
      selectedCustomTemplates: [],
      canUpdateQuote: false,
      selectedSite: {},
      selectedShop: {},
      editMode: false,
      form: new Form(),
      mountStateModal: false,
      mountForceQuote: false,
      mountStaffModal: false,
      mountUpdateQuoteModal: false,
      mountSearchQuote: false,
      mountProductModal: false,
      mountQuoteModal: false,
      mountEditMaterialProduct: false,
      mountEditLabourProduct: false,
      loaded: true,
      page: 1,
      formSubmitting: true,
      selectedSale: {},
      productVariants: [],
      showCustomerList: false,
      modals: {
        newQuote: {
          show: false,
          method: "",
          isBatch: false,
          showClients: false,
          quote_id: "",
          client_id: ""
        },
        memo: {
          show: false,
          values: { user_id: "" }
        },
        updateQuote: {
          show: false,
          values: {
            job_id: "",
            initiation_date: currentDate,
            invoice: { receipt_date: currentDate, date: currentDate }
          }
        }
      },
      salesCodeId: '',
      memos: [],
      values: {
        customerDetails: {
          address: {},
          manual: false
        },
        commission_percentage: 0,
        guided_percentage: 0,
        quote_gst: 10,
        quote: {
          id: "",
          customer_id: "",
          project: "",
          remarks: "",
          metadata: {},
          job_source_id: "",
          commission_percentage: 0,
          inclusive_total: 0,
          type: '',
          gst: '',
          calculated_total_sell: '',
          gst_inclusive_quote: '',
          term: {},
          quote_price: 0,
          costed_commission: 0,
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
      jobSources: [],
      staffs: [],
      selectedJobSourceId: {},
      mountTermsModal: false,
      mountAddMemo: false,
      selectedStaff: {},
      selectedMaterialProduct: {},
      selectedMaterialProductIndex: '',
      selectedLabourProduct: {},
      selectedMemoForEdit: {},
    };
  },
  computed: {
    salesCode() {
      return this.findSalesCode(this.salesCodeId);
    },
    selectedVariantIds() {
      if (!this.values.materials.length) {
        return [];
      }
      return this.values.materials.map(material => material.variant_id);
    },
    quoteMargin() {
      const margin = this.values.quote.quote_price - Number(this.totalCost);
      return margin.toFixed(2);
    },
    quoteMarkUp() {
      const value = (Number(this.quoteMargin) / Number(this.totalCost)) * 100;
      return value.toFixed(2);
    },
    quoteGrossProfit() {
      if (!this.values.quote.quote_price || this.values.quote.quote_price == 0) {
        return 0;
      }
      const value = ((Number(this.quoteMargin) / this.values.quote.quote_price) * 100) || 0;
      return value.toFixed(2);
    },
    quoteTerm() {
      return get('terms.quote', this.values.quote.term);
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
      //   let cost = Number(material.unit) * Number(material.quantity);
      //   if (material.levy) {
      //     cost = cost + ((cost * material.levy) / 100);
      //   }
      //   if (material.discount) {
      //     cost = cost - ((cost * material.discount) / 100);
      //   }
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

      return sum.toFixed(2);
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
    /**
     * Calculate the net cost.
     */
    netCost() {
      const cost = Number(this.labourGrandTotal) + Number(this.materialGrandTotal);
      return cost.toFixed(2)
    },
    commissionAmount() {
      let { commission_percentage } = this.values;

      const cost = Number(this.netCost) * (commission_percentage / 100);
      return cost.toFixed(2);
    },
    guidedAmount() {
      let { guided_percentage } = this.values;

      const cost = Number(this.totalCost) + (Number(this.totalCost) * (guided_percentage / 100));
      return cost.toFixed(2);
    },
    totalCost() {
      const cost = Number(this.netCost) + Number(this.values.quote.costed_commission);
      return cost.toFixed(2)
    },
    costedCommission() {
      const cost = Number(this.netCost) + Number(this.commissionAmount);
      return cost.toFixed(2);
    },
    selectedJobSource() {
      return (
        this.jobSources.find(
          jobSource => jobSource.id === this.values.quote.job_source_id
        ) || {}
      );
    },
    calculatedGST() {
      if (!this.values.quote || !this.values.quote.inclusive_total) {
        return 0;
      }
      return (this.values.quote_gst/100) * this.values.quote.inclusive_total;
    },
    calculatedNetPrice() {
      if (!this.values.quote || !this.values.quote.inclusive_total) {
        return 0;
      }
      return this.values.quote.inclusive_total - this.calculatedGST;
    },
    netQuotePrice() {
      const price = (100 * Number(this.values.quote.gst_inclusive_quote)) / (100 + Number(this.values.quote.gst));
      return price.toFixed(2);
    },
    gstValue() {
      const value = (this.values.quote.quote_price * Number(this.values.quote.gst)) / 100;
      return value.toFixed(2);
    },
  },
  watch: {
    'values.quote.gst': {
      handler: function (gst) {
        this.values.quote.gst_amount = (this.values.quote.quote_price * Number(gst)) / 100;
      }
    },
    // 'values.quote.quote_price': {
    //   handler: function (price) {
    //     this.values.quote.gst_amount = (this.values.quote.quote_price * Number(this.values.quote.gst)) / 100;
    //   }
    // },
    quote: {
      handler: function(quote) {
        if (isEmpty(quote)) {
          return;
        }
        this.fetchAccountsBySite(quote.site_id);
        return this.mapEditQuoteToValue(quote);
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
  },
  methods: {
    formatViewDate,
    displayMoney,
    displayNumber,
    deleteQuote() {
      let confirmation = confirm('Are you sure you want to delete?');
      if (confirmation) {
        axios.delete(`/api/quotes/${this.quote.id}`)
          .then(() => {
            this.$toastr('success', 'Successfully deleted quote.', 'Success!!');
            window.location.href = '/quotes'
          })
          .catch(() => {
            this.$toastr('error', 'Could not delete quote', 'Error!!')
          })
          .finally(this.handleClose);
      }
    },
    closeAddMemoModal() {
      this.selectedMemoForEdit = {};
      this.mountAddMemo = false;
    },
    editMemoModal(memo) {
      this.selectedMemoForEdit = {...memo};
      this.mountAddMemo = true;
    }, 
    memoSaved() {
      this.refreshQuotePage();
    },
    refreshQuotePage(page = 2) {
      window.location.href = `/quotes/${this.quote.id}/edit?page=${page}`;
    },
    getMaterialTotalFirstPage(material) {
      const cost = Number(material.quantity) * Number(material.unit_sell || 0);
      return cost.toFixed(2);
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
      getAccountsBySite(siteId)
        .then(({ data }) => {
          this.accounts = data.data;
        })
        .catch(() => {
          console.log('could not fetch accounts');
        })
        .finally(this.disableLoading);
    },
    calculate() {
      const gstInclusiveQuote = Number(this.values.quote.quote_price) + Number(this.values.quote.gst_amount);
      this.values.quote.gst_inclusive_quote = gstInclusiveQuote.toFixed(2);
    },
    mediaButton(action) {
      if (action === 'prev' && this.previous) {
        window.location.href = `/quotes/${this.previous}/edit`
      }
      if (action === 'next' && this.next) {
        window.location.href = `/quotes/${this.next}/edit`
      }
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
      this.values.quote.term = term;
    },
    selectNewState({ state, suburb, code }) {
      if (this.values.customerDetails) {
        this.values.customerDetails.address.state = state;
        this.values.customerDetails.address.town = suburb;
        this.values.customerDetails.address.code = code;
      }
    },
    materialTotal(product) {
      const listCost = product.list_cost ? Number(product.list_cost) : 0;
      const discount = product.discount ? Number(product.discount) : 0;
      const levy = product.levy ? Number(product.levy) : 0;
      let cost = listCost;
      if (discount) {
        cost = listCost - (listCost * discount) / 100;
      }
      if (levy) {
        cost = cost + (cost * levy) / 100;
      }
      return cost;
    },
    addQuoteData(data) {
      axios
        .post("/api/mergedtemplates", data.templates)
        .then(({ data: tempData }) => {
          this.selectedCustomTemplates = tempData.data;
          this.values.quote.type = this.selectedCustomTemplates.name;
          this.values.quote.remarks = this.selectedCustomTemplates.remarks;
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
        this.values.quote.customer_id = data.client_id;
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
            this.values.quote.gst = this.selectedSite.gst;
            this.values.quote.gst_amount = 0;
          });
        this.fetchJobSourcesAndSalesStaff(data.store_id);
      }

      this.values.quote.term = data.term;
      this.values.quote.quote_date = data.quote_date;
      this.values.quote.job_source_id = data.source_id;
      this.values.quote.shop_id = data.shop_id;
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
        this.values.quote.job_source_id = data;
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
      });
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
      this.values.quote.commission = {
        commission_percentage,
        guided_percentage,
        quote_gst,
        notes
      };
      this.values.quote.labour = this.values.labours;
      this.values.quote.site_id = this.selectedSite.id;
      this.values.quote.material_total = Number(this.materialGrandTotal);
      this.values.quote.labour_total = Number(this.labourGrandTotal);
      this.values.quote.net_cost = this.netCost;
      this.values.quote.total_cost = this.totalCost;
      this.values.quote.margin = this.quoteMargin;
      this.values.quote.markup = this.quoteMarkUp;
      this.values.quote.gp = this.quoteGrossProfit;
      this.calculate();
      this.form = new Form(this.values);

      $("html, body").animate({ scrollTop: 0 }, "slow");
      this.form
        .onSubmit(this.method, this.url)
        .then(({ data }) => {
          this.$toastr("success", this.form.alertMessage, "Success!!");
          const quoteId = this.quote.id || data.id;
          window.location.href = `/quotes/${quoteId}/edit`;
        })
        .catch(errors => {
          this.$toastr("error", this.form.alertMessage, "Error!!");
        });
    },
    /**
     * Map quote value on edit.
     * @param {Object} quote
     * */
    mapEditQuoteToValue(quote) {
      this.selectedSite = { ...quote.site };
      this.selectedShop = { ...quote.shop };
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
        costed_commission,
        quote_price,
        sales_code_id,
        quote_date,
        memo_references
      } = quote;

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

      if (quote.commission !== null) {
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

      this.salesCodeId = sales_code_id;

      this.selectedJobSourceId = this.findJobSource(job_source_id);
      this.values.quote = {
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
        costed_commission,
        quote_price,
        quote_date,
      };

      this.memos = memo_references;

      let materialSalesPrice = quote.materials;

      materialSalesPrice = materialSalesPrice.map(materialSale => ({
        product_id: materialSale.product ? materialSale.product.id : null,
        supplier_id: materialSale.supplier ? materialSale.supplier.id : materialSale.product.supplier.id,
        product_name: materialSale.product ? materialSale.product.name : 'Bailing/Delivery',
        product_upc: materialSale.product ? `${materialSale.product.supplier_id} - ${materialSale.product.upc || materialSale.product.id}` : "",
        supplier_name: materialSale.supplier ? materialSale.supplier.trading_name : materialSale.product.supplier.trading_name,
        variant_name: materialSale.variant ? materialSale.variant.name : "",
        variant_id: materialSale.variant ? materialSale.variant.id : null,
        unit: materialSale.unit,
        unit_sell: materialSale.unit_sell,
        levy: materialSale.levy,
        discount: materialSale.discount,
        quantity: materialSale.quantity,
        total: materialSale.total,
        gst: materialSale.gst,
      }));

      this.values.materials = materialSalesPrice;

      this.values.labours = labour;

      // let labourSalesPrice = quote.labour_sales_price;
      // labourSalesPrice = labourSalesPrice.map((labourSale) => ({
      //   product: labourSale.name,
      //   labour_product_id: labourSale.id,
      //   quantity: labourSale.pivot.quantity,
      //   unit: labourSale.pivot.unit,
      //   total: labourSale.pivot.total,
      // }));
      // this.values.labours = labourSalesPrice;

      this.values.selectedSales = quote.sales.map(sale => {
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
      this.values.quote.customer_id = customer.id;
      this.values.customerDetails = customer;
      this.values.customerDetails.address = Array.isArray(customer.address) ? { ...BASE_ADDRESS } : { ...BASE_ADDRESS , ...customer.address };
      this.values.customerDetails.manual = false;
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
        let product = this.getProductById(productId);
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
     * @param index
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
        material.total = this.productPrice;
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
          address: {}
        };
      } else {
        axios
          .get(`/customers/${customerId}/details`)
          .then(response => {
            this.showCustomerList = false;
            this.values.customerDetails = response.data.data;
            this.values.customerDetails.address =
              response.data.data.address || {};
            this.values.customerDetails.manual = false;
          })
          .catch(error => {
            this.showCustomerList = true;
          });
      }
    },
    /**
     * Handle the quote creation modal.
     * **/
    handleQuoteCreation(method) {
      this.modals.newQuote.showClients = false;
      this.modals.newQuote.client_id = "";
      this.modals.newQuote.quote_id = "";

      if (method === "copy_from_current") {
        this.modals.newQuote.quote_id = this.quote.id;
      }
      if (method === "choose_from_client") {
        this.modals.newQuote.client_id = "";
        this.modals.newQuote.showClients = true;
      }
    },
    /**
     * Get and set the latest quote id for the client.
     * */
    getQuoteIdFromClient(clientId) {
      axios
        .get(`/customers/${clientId}/latest-quote-id`)
        .then(({ data }) => {
          this.modals.newQuote.quote_id = data === null ? "" : data;
        })
        .catch(error => alert("Please try again"));
    },
    /**
     * Proceed to the quote creation page.
     * */
    proceedQuoteCreatePage() {
      const { newQuote } = this.modals;
      if (
        newQuote.method === "" ||
        (newQuote.method === "choose_from_client" && newQuote.client_id === "")
      ) {
        this.$toastr("error", "Please select appropriate data.", "Error!!");
        return false;
      }
      const { quote_id, isBatch } = newQuote;
      location.href = `/quotes/create?quote_id=${quote_id}&is_batch=${isBatch}&templates=${this.values.selectedTemplates}`;
    },

    /**
     * Create a memo
     * **/
    createMemo() {
      let { values } = this.modals.memo;
      values.reference_id = this.quote.id;
      values.reference_type = "quote";
      this.form = new Form(values);
      $("html, body").animate({ scrollTop: 0 }, "slow");
      this.form
        .onSubmit("post", `/api/memos`)
        .then(response => {
          this.$toastr("success", this.form.alertMessage, "Success!!");
          location.reload();
        })
        .catch(errors => {
          this.$toastr("error", this.form.alertMessage, "Error!!");
        });
    },
    updateQuoteToJob() {
      let { values } = this.modals.updateQuote;
      this.form = new Form(values);
      $("html, body").animate({ scrollTop: 0 }, "slow");
      this.form
        .onSubmit("post", `/quotes/${this.quote.id}/convert-to-job`)
        .then(response => {
          this.$toastr("success", this.form.alertMessage, "Success!!");
          location.href = `/jobs/${response.data.id}/edit`;
        })
        .catch(errors => {
          this.$toastr("error", this.form.alertMessage, "Error!!");
        });
    },
    showAddBookingModal() {
      const bookingModal = this.modals.newBooking;
      bookingModal.values.job_id = this.quote.id;
      bookingModal.values.customer = this.quote.trading_name;
      bookingModal.values.location = this.quote.address ? this.quote.address.town : '';
      bookingModal.show = true;
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
    openQuoteModal() {
      this.mountQuoteModal = true;
    },
    closeQuoteModal() {
      this.mountQuoteModal = false;
    },
    openUpdateQuoteModal() {
      this.mountUpdateQuoteModal = true;
    },
    closeUpdateQuoteModal() {
      this.mountUpdateQuoteModal = false;
    },
    closeSearchQuote() {
      this.mountSearchQuote = false;
    },
    openSearchQuote() {
      this.mountSearchQuote = true;
    },
    openModal(type) {
      this[`mount${type}`] = true;
    },
    closeModal(type) {
      this[`mount${type}`] = false;
    },
    handleForcedPrice(forcedPrice) {
      this.values.quote.gst_inclusive_quote = forcedPrice;
      const price = (100 * Number(forcedPrice)) / (100 + Number(this.values.quote.gst));
      const netQuotePrice = price.toFixed(2);
      this.values.quote.quote_price = netQuotePrice;
      const gstAmount = forcedPrice - Number(netQuotePrice);
      this.values.quote.gst_amount = gstAmount.toFixed(2);
    },
  }
};
</script>

<style lang="scss">
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
.background-black {
  background-color: black;
  color: white;
  width: fit-content;
  padding: 2px 5px;
}

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
