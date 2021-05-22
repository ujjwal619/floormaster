<script>
  import axios from 'axios';
  import PortletContent from '../../../common/components/Portlets/Content/PortletContent'
  import CurrentStockAllocation from './CurrentStockAllocation'
  import FutureStockAllocation from './FutureStockAllocation'
  import Modal from '../../../common/components/Modal/Modal'
  import Page1 from './Page1'
  import Page2 from './Page2'
  import Page3 from './Page3'
  import Page4 from './Page4'
  import Page5 from './Page5'
  import Page6 from './Page6'
  import FutureStockError from './FutureStockError'
  import CurrentStockError from './CurrentStockError'
  import MoveError from './components/MoveError'
  import EditAllocation from './EditAllocation';
  import EditBackOrder from './EditBackOrder';
  import UnlinkAllocation from './UnlinkAllocation';
  import DeleteAllocation from './DeleteAllocation';
  import DispatchAllocation from './components/DispatchAllocation';
  import UnlinkBackOrder from './UnlinkBackOrder';
  import DeleteBackOrder from './DeleteBackOrder';
  import Form from '../../../common/utitlities/Form'
  import DropDown from '../../../common/components/DropDown/DropDown'
  import { 
    LoadingMixin 
  } from '../../../common/mixins'
  import { 
    getCurrentStockList,
    getSites,
    getProductsBySupplier,
    getColorsByProduct,
    getSuppliersBySite,
    getMyProfile,
    patchBackOrderToCurrentStock,
    patchBackOrderToFutureStock,
    patchAllocationToCurrentStock,
    patchAllocationToFutureStock,
    getActionRequired,
    isMySite,
  } from '../../api/calls'
  import { formatViewDate } from '../../../common/utitlities/helpers';
  
  const DISPATCH_TOTAL_COUNT = 21;

  const BASE_OPENING_STOCK = {
    batch: null,
    roll_no: '',
    size: null,
    location: '',
    nb: '',
    supplier_inv_no: null,
    unit_cost: null,
    levy: null,
    selling_price: null,
    received_date: null,
    gl_date: null
  };

  const BASE_ADD_STOCK = {
    interim_order_number: null,
    supplier_reference: '',
    delivery_address: {},
    supplier_details: {
      placed_with: '',
    },
    show: false,
    values: {
      add_stock_id: null,
      quantity: null,
      unit: null,
      list_price: null,
      discount: null,
      delivery: null,
      tax: null,
      levy: null,
      sell_price: null,
      delivery_date: '',
    },
  };

  const BASE_ALLOCATION = {
    show: false,
    selected: {},
    values: {
      client: '',
      project: '',
      amount: null,
      job_no: '',
      date_required: '',
      notes: '',
      drop_off_date: null,
      hold_days: null,
      shop: null,
    },
    selected: {
      job: {}
    },
  };

  const BASE_CURRENT_ALLOCATION = {
    show: false,
    values: {
      allocation_quantity: null,
    },
  };

  const BASE_MOVE_DATA = {
    step: 1,
    data: {},
  };

  const PAGE_TITLE = [
    'Add Stock Order Item', 
    'Making Stock Order',
    'Placing Stock Order', 
    'Delivery Address', 
    "New Order - Supplier's Reference", 
    'New Stock Order Placed'
  ];

  const OPENING_STOCK_RULES = [
    'batch',
    'roll_no',
    'size',
    'received_date',
    'gl_date',
  ];

  const ALLOCATION_RULES = [
    'amount',
  ];

  const ALLOCATION = 'ALLOCATION';
  const BACK_ORDER = 'BACK ORDER';

  // @TODO: validation for future stock modal

  export default {
    name: "Stocks",
    mixins: [LoadingMixin],
    components: {
      PortletContent,
      Modal,
      Page1,
      Page2,
      Page3,
      Page4,
      Page5,
      Page6,
      Form,
      DropDown,
      CurrentStockAllocation,
      FutureStockAllocation,
      FutureStockError,
      CurrentStockError,
      MoveError,
      EditAllocation,
      EditBackOrder,
      UnlinkAllocation,
      UnlinkBackOrder,
      DeleteAllocation,
      DispatchAllocation,
      DeleteBackOrder,
    },
    props: {
      color: {
        type: Object,
        required: true,
      },
      product: {
        type: Object,
        required: true,
      },
      supplier: {
        type: Object,
        required: true,
      },
      currentStockList: {
        type: [Array, Object],
        default: () => [{}]
      },
      futureStocks: {
        type: [Array, Object],
        default: () => [{}]
      },
      stock: {
        type: Object,
        required: true
      },
      products: {
        type: Array,
        default: () => [{}]
      },
    },
    data:() => ({
      jobMaterials: [],
      currentUser: {
        permissions: [],
      },
      isSuperAdmin: false,
      currentPageIndex: 0,
      newStock: [],
      form: new Form(),
      updatedStock: {},
      modals: {
        openingStock: {
          rolls: [],
          show: false,
          values: { ...BASE_OPENING_STOCK },
        },
        addStock: { ...BASE_ADD_STOCK },
        search: {
          show: false,
          values: {},
        },
        allocation: { ...BASE_ALLOCATION },
        allocateCurrentStock: { ...BASE_CURRENT_ALLOCATION },
      },
      pageList: [
        'Page1', 'Page2', 'Page3', 'Page4', 'Page5', 'Page6'
      ],
      selectedAllocation: {},
      allocatingStock: {},
      selectedCurrentStock: {},
      jobs: [],
      selectedFutureStock: {},
      mountFutureStock: false,
      mountFutureStockError: false,
      mountCurrentStockError: false,
      mountMoveError: false,
      mountEditAllocation: false,
      mountEditBackOrder: false,
      mountUnlinkAllocation: false,
      mountUnlinkBackOrder: false,
      mountDispatchAllocation: false,
      mountDeleteAllocation: false,
      mountDeleteBackOrder: false,
      selectedBackOrder: {},
      currentStocks: {},
      selectedSite: NaN,
      selectedSupplier: NaN,
      selectedProduct: NaN,
      sites: [],
      suppliersList: [],
      productsList: [],
      colorsList: [],
      dispatchAllocationSeries: [],
      page: 1,
      moveData: { ...BASE_MOVE_DATA },
      isEditMode: false,
      isDeleteMode: false,
      isDispatchMode: false,
      isMoveMode: false,
      isUsersSite: false,
    }),
    computed: {
      defaultJobMaterialSale() {
        const jobMaterialSale = this.stock.ongoing_allocation_job_material_id;
        if (!jobMaterialSale) {
          return this.jobMaterials[0];
        }

        return this.jobMaterials.find((jobMaterial) => jobMaterial.id === jobMaterialSale) || {};
      },
      isAllocationOngoing() {
        return this.stock.is_allocation_ongoing && this.stock.ongoing_allocation_causer.id === this.currentUser.id;
      },
      allocationDispatches() {
        return this.color.allocation_dispatches || [];
      },
      allDispatches() {
        const dispatches = [...this.allocationDispatches];
        for(let i = dispatches.length; i<DISPATCH_TOTAL_COUNT; i++) {
          dispatches.push({});
        }
        return dispatches;
      },
      isAnyModeActive() {
        return this.isEditMode || 
          this.isDeleteMode || 
          this.hasOngoingAllocation || 
          this.isDispatchMode ||
          this.isMoveMode;
      },
      activeModeMessage() {
        if (this.hasOngoingAllocation) {
          return `Allocating to ${this.allocatingStock.client}, re: ${this.allocatingStock.project}, 
            ${this.allocatingStock.amount}. Click to Select Current or Future Stock.`
        } else if (this.isEditMode) {
          return 'EDIT MODE is active. Click to select item.';
        } else if (this.isDeleteMode) {
          return 'DELETE MODE is active. Click to select item.';
        } else if (this.isDispatchMode) {
          return 'DISPATCH MODE active. Select Item or Allocation to Dispatch.';
        } else if (this.isMoveMode) {
          return this.isMoveModeStep1 ? 
            'MOVE is active. Click to select Item. Allocation or Back Order' :
            `${this.moveData.module} MODE is active. Click on destination Current or Future Stock.`; 
        } else {
          return '';
        }
      },
      ongoingAllocationJob() {
        return this.jobs.find(job => job.id === this.stock.ongoing_allocation_job_material_sale.job_id);
      },
      total4SellOverall() {
        return Number(this.stock.current_stock_total_for_sell) + Number(this.stock.future_stock_total_for_sell)
      },
      totalAllocationsAndBackOrders() {
        return (Number(this.stock.total_allocations) + Number(this.stock.total_back_orders)).toFixed(2);
      },
      hasOngoingAllocation() {
        return !!Object.keys(this.allocatingStock).length;
      },
      stopAllocation() {
        const { values } = this.modals.allocation;
        return ALLOCATION_RULES.some((key) => !values[key]);
      },
      stopStoreRoll() {
        const { values } = this.modals.openingStock;
        const isNotValid = OPENING_STOCK_RULES.some((key) => !values[key]);
        return isNotValid;
      },
      isDataValid() {
        return !!this.modals.addStock.interim_order_number;
      },
      getFormattedData() {
        return {
          futureStocks: [...this.newStock],
          supplier_details: this.modals.addStock.supplier_details,
          delivery_address: this.modals.addStock.delivery_address || {},
          supplier_reference: this.modals.addStock.supplier_reference,
          interim_order_number: this.modals.addStock.interim_order_number,
        };
      },
      isLastPage() {
        return this.currentPageIndex === (this.pageList.length - 1);
      },
      isFirstPage() {
        return this.currentPageIndex === 0;
      },
      getTitle() {
        return PAGE_TITLE[this.currentPageIndex];
      },
      getPageData() {
        return this.modals.addStock;
      },
      currentPage() {
        return this.pageList[this.currentPageIndex];
      },
      getStoredRolls() {
        return [...this.modals.openingStock.rolls];
      },
      storedRolls() {
        const rolls = this.getStoredRolls;
        if (!rolls) {
          return '';
        }
        const batchAreaInfo = rolls.map(roll => {
          return `${roll.batch},     ${roll.size} of Roll No: ${roll.roll_no}, Dye: ${roll.batch}
          `;
        });
        
        return batchAreaInfo.reduce((acc, currentValue) => `${acc}${currentValue}`, '');
      },
      openingStockModalTitle() {
        return this.isEditMode ? 'Edit Opening Stock' : 'Enter Opening Stock'
      },
      colors() {
        const productId = this.modals.search.values.product;
        if (!productId) {
          return [];
        }

        return this.findColors(productId);
      },
      futureStockForSell() {
        return this.futureStocks.reduce((a, b) => {
          return a + (Number(b.quantity) - Number(b.received));
        }, 0)
      },
      site() {
        return this.supplier.site || {};
      },
      isMoveModeStep1() {
        return this.isMoveMode  && this.moveData.step === 1 ? true : false;
      },
      isMoveModeStep2() {
        return this.isMoveMode  && this.moveData.step === 2 ? true : false;
      },
    },
    watch: {
      stock: {
        immediate: true,
        handler(stock) {
          this.updatedStock.notes = stock.notes || '';
          this.updatedStock.reorder = stock.reorder;
        }
      },
      selectedSite(siteId) {
        this.selectedSupplier = NaN;
        this.$refs.supplier.reset();
        if (siteId) {
          this.fetchSuppliers(siteId);
        }
      },
      selectedSupplier(supplierId) {
        this.selectedProduct = NaN;
        this.$refs.productSelect.reset();
        if (supplierId) {
          this.fetchProduct(supplierId);
        }
      },
      selectedProduct(productId) {
        this.modals.search.values.color = NaN;
        this.$refs.colorSelect.reset();
        if (productId) {
          this.fetchColors(productId);
        }
      },
      'modals.allocation.values.job_id': {
        deep: true,
        handler(value) {
          if (value) {
            this.$refs.materialsSelect.reset();
            this.jobMaterials = [];
            this.modals.allocation.values.job_material_id = ''
            this.fetchJobMaterials(value);
          }
        },
      }
    },
    created() {
      this.isThisMySite(this.color.site_id);
      this.enableLoading();
      const urlParams = new URLSearchParams(window.location.search)
      if (urlParams.has('page')) {
        this.page = Number(urlParams.get('page'));
      }

      this.currentStocks = this.currentStockList;

      getMyProfile()
        .then(({ data }) => {
          this.currentUser = data.data;
          this.isSuperAdmin = data.meta.is_super_admin;
          this.fetchJobs()
            .then(() => {
                if (this.stock.is_allocation_ongoing && this.stock.ongoing_allocation_causer.id === this.currentUser.id) {
                  this.modals.allocation.selected.job = this.ongoingAllocationJob;
                  this.modals.allocation.values.amount = this.stock.ongoing_allocation_job_material_sale.quantity - this.stock.ongoing_allocation_job_material_sale.allocated - this.stock.ongoing_allocation_job_material_sale.dispatched;
                  this.modals.allocation.values.job_material_id = this.stock.ongoing_allocation_job_material_id;
                  this.modals.allocation.values.client = this.ongoingAllocationJob.trading_name;
                  this.modals.allocation.values.project = this.ongoingAllocationJob.project;
                  this.showAllocationModal();
                  axios.patch(`/api/color/${this.stock.ongoing_allocation_job_material_sale.variant_id}/disable-allocation-process`)
                    .then().catch(() => console.log('could not disable allocation process'));
                }
            })
        })
        .finally(this.disableLoading);
    },
    methods: {
      formatViewDate,
      isThisMySite(siteId) {
        isMySite(siteId)
          .then(({ data }) => {
            this.isUsersSite = data.data.is_my_site;
          })
          .catch(() => {
            console.log('could not fetch accounts.');
          })
      },
      fetchJobMaterials(jobId) {
        this.enableLoading();
        getActionRequired({job: jobId, color: this.color.id, act_on: 1})
          .then(({ data }) => {
            this.jobMaterials = data.data;
          })
          .catch(() => {
            this.$toastr('error', 'Could not fetch Job Materials.');
          })
          .finally(this.disableLoading);
      },
      enableMoveMode() {
        this.moveData.step = 1;
        this.isMoveMode = true;
      },
      continueDispatchAllocation() {
        const allocations = this.color.allocations;
        const allocation = allocations.find(allocation => {
          return !this.dispatchAllocationSeries.includes(allocation.id);
        })
        if (allocation) {
          this.selectedAllocation = allocation;
          this.dispatchAllocationSeries.push(allocation.id);
        } else {
          this.closeModal('DispatchAllocation');
          this.dispatchAllocationSeries = [];
          window.location.reload();
        }
      },
      redirectToJob(job) {
        if (!job){
          return;
        }

        window.location.href = `/jobs/${job.id}/edit?page=2`;
      },
      setCurrentPage(index) {
        this.currentPageIndex = index;
      },
      addOpeningStockModal() {
        this.modals.openingStock.show = true;
      },
      updateOpeningStockModal(currentStock) {
        this.isEditMode = true;
        this.modals.openingStock.values.batch = currentStock.batch;
        this.modals.openingStock.values.gl_date = currentStock.gl_date;
        this.modals.openingStock.values.levy = currentStock.levy;
        this.modals.openingStock.values.location = currentStock.location;
        this.modals.openingStock.values.nb = currentStock.nb;
        this.modals.openingStock.values.received_date = currentStock.received_date;
        this.modals.openingStock.values.roll_no = currentStock.roll_no;
        this.modals.openingStock.values.selling_price = currentStock.selling_price;
        this.modals.openingStock.values.size = currentStock.size;
        this.modals.openingStock.values.supplier_inv_no = currentStock.supplier_inv_no;
        this.modals.openingStock.values.unit_cost = currentStock.unit_cost;
        this.modals.openingStock.values.id = currentStock.id;
        this.modals.openingStock.show = true;
      },
      handleOpeningStockModalClose() {
        this.isEditMode = false;
        this.modals.openingStock = {
          rolls: [],
          show: false,
          values: { ...BASE_OPENING_STOCK },
        };
      },
      addStockItemModal() {
        this.modals.addStock.values.list_price = this.product.list_cost;
        this.modals.addStock.values.unit = this.product.unit;
        this.modals.addStock.values.discount = this.product.discount;
        this.modals.addStock.values.tax = this.product.gst;
        this.modals.addStock.values.levy = this.product.levy;
        this.modals.addStock.values.delivery = this.supplier.delivery;
        this.modals.addStock.show = true;
      },
      handleStockItemModalClose() {
        this.modals.addStock = { ...BASE_ADD_STOCK };
        this.newStock = [];
        this.setCurrentPage(0);
      },
      openFutureStockAllocation() {
        this.mountFutureStock = true;
      },
      closeFutureStockAllocation() {
        this.mountFutureStock = false;
      },
      // clickedOnCurrentStock(currentStock) {
      //   if (!this.isEditMode) {
      //     if (!this.hasOngoingAllocation || this.isMoveModeStep1) {
      //       return;
      //     }
      //     if (currentStock.size - currentStock.sold === 0) {
      //       return this.openErrorModal('CurrentStock');
      //     }
      //     if (this.isMoveModeStep2) {
      //       //call api
      //       console.log('allocate to current stock')
      //     }
      //     this.allocateCurrentStock(currentStock);
      //   } else {
      //     this.updateOpeningStockModal(currentStock);
      //   }
      // },
      clickedOnCurrentStockCopy(currentStock) {
        if (this.isDispatchMode || 
          this.isDeleteMode ||
          this.isMoveModeStep1
        ) {
          return;
        }

        if (this.isEditMode) {
          return this.updateOpeningStockModal(currentStock);
        }

        const isNoForSale = Number(currentStock.size) - Number(currentStock.sold) === 0;
        console.log(isNoForSale, currentStock.size, currentStock.sold)
        if (this.hasOngoingAllocation) {
          // if (isNoForSale) {
          //   console.log('error');
          //   return this.openErrorModal('CurrentStock');
          // }
          return this.allocateCurrentStock(currentStock);
        }

        if (this.isMoveModeStep2) {
          if (isNoForSale) {
            this.moveData.errorModule = 'current-stock';
            return this.openErrorModal('Move');
          }
          return this.moveData.module === ALLOCATION ? 
            this.moveAllocationToCurrentStock(this.moveData.id, currentStock.id) : 
            this.moveBackOrderToCurrentStock(this.moveData.id, currentStock.id);
        }
      },
      moveBackOrderToCurrentStock(backOrderId, currentStockId) {
        this.enableLoading();
        patchBackOrderToCurrentStock(backOrderId, currentStockId)
          .then(() => {
            this.refreshStockPage();
          })
          .catch(() => {
            this.$toastr('error', 'Cannot move backorder to current stock.', 'Error!!');
          })
          .finally(this.disableLoading);
      },
      moveBackOrderToFutureStock(backOrderId, futureStockId) {
        this.enableLoading();
        patchBackOrderToFutureStock(backOrderId, futureStockId)
          .then(() => {
            this.refreshStockPage();
          })
          .catch(() => {
            this.$toastr('error', 'Cannot move backorder to future stock.', 'Error!!');
          })
          .finally(this.disableLoading);
      },
      moveAllocationToCurrentStock(allocationId, currentStockId) {
        this.enableLoading();
        patchAllocationToCurrentStock(allocationId, currentStockId)
          .then(() => {
            this.refreshStockPage();
          })
          .catch(() => {
            this.$toastr('error', 'Cannot move allocation to current stock.', 'Error!!');
          })
          .finally(this.disableLoading);
      },
      moveAllocationToFutureStock(allocationId, futureStockId) {
        this.enableLoading();
        patchAllocationToFutureStock(allocationId, futureStockId)
          .then(() => {
            this.refreshStockPage();
          })
          .catch(() => {
            this.$toastr('error', 'Cannot move allocation to future stock.', 'Error!!');
          })
          .finally(this.disableLoading);
      },
      // clickedOnFutureStock(futureStock) {
      //   if (this.isDispatchMode || this.isMoveModeStep1) {
      //     return;
      //   }
      //   if (!this.hasOngoingAllocation) {
      //     this.redirectToCurrentOrders(futureStock.order_number);
      //     return;
      //   }
      //   if (Number(this.allocatingStock.amount) > (futureStock.quantity - futureStock.sold)) {
      //     this.openErrorModal('FutureStock');
      //   } else {
      //     this.selectedFutureStock = futureStock;
      //     this.openFutureStockAllocation();
      //   }
      // },
      clickedOnFutureStockCopy(futureStock) {
        if (this.isDispatchMode || 
          this.isEditMode || 
          this.isMoveModeStep1 ||
          this.isDeleteMode
        ) {
          return;
        }

        const forSale = (futureStock.quantity - futureStock.sold) > 0 ? 
          (futureStock.quantity - futureStock.received - futureStock.sold) : 0;
        
        const isNoForSale = forSale === 0;

        if (this.isMoveModeStep2) {
          if (isNoForSale) {
            this.moveData.errorModule = 'future-stock';
            return this.openErrorModal('Move');
          }
          return this.moveData.module === ALLOCATION ? 
            this.moveAllocationToFutureStock(this.moveData.id, futureStock.id) : 
            this.moveBackOrderToFutureStock(this.moveData.id, futureStock.id);
        }

        if (this.hasOngoingAllocation) {
          if (Number(this.allocatingStock.amount) > Number(forSale)) {
            return this.openErrorModal('FutureStock');
          }

          this.selectedFutureStock = futureStock;
          this.openFutureStockAllocation();
          return;
        }

        this.redirectToCurrentOrders(futureStock.order_number);
      },
      clickedOnBackOrder(backOrder) {
        if (this.hasOngoingAllocation || this.isDispatchMode || this.isMoveModeStep2) {
          return;
        }

        if (this.isEditMode) {
          this.selectedBackOrder = backOrder;
          this.openModal('EditBackOrder');
        } else if (this.isDeleteMode) {
          this.selectedBackOrder = backOrder;
          this.openModal('DeleteBackOrder');
        } else if(this.isMoveModeStep1) {
          this.moveData.id = backOrder.id;
          this.moveData.data = backOrder;
          this.moveData.module = BACK_ORDER;
          this.moveData.step = 2;
        } else {
          this.redirectToJob(backOrder.job);
        }
      },
      clickedOnAllocation(allocation) {
        if (this.hasOngoingAllocation || this.isMoveModeStep2) {
          return;
        }

        if (this.isEditMode) {
          this.selectedAllocation = allocation;
          this.openModal('EditAllocation');
        } else if (this.isDeleteMode) {
          this.selectedAllocation = allocation;
          this.openModal('DeleteAllocation');
        } else if (this.isDispatchMode) {
          this.dispatchAllocationSeries.push(allocation.id);
          this.selectedAllocation = allocation;
          this.openModal('DispatchAllocation');
        } else if(this.isMoveModeStep1) {
          this.moveData.id = allocation.id;
          this.moveData.data = allocation;
          this.moveData.module = ALLOCATION;
          this.moveData.step = 2;
        } else {
          this.redirectToJob(allocation.job);
        }
      },
      openErrorModal(type) {
        this[`mount${type}Error`] = true;
      },
      closeErrorModal(type) {
        this[`mount${type}Error`] = false;
      },
      storeRoll() {
        this.validate().then(valid => {
          if (valid) {
            this.modals.openingStock.rolls.push({...this.modals.openingStock.values, site_id: this.color.site_id});
            this.modals.openingStock.values = { ...BASE_OPENING_STOCK };  
          }
        });
      },
      validate() {
        return this.$validator.validate();
      },
      saveCurrentStock() {
        if (!this.isEditMode && !this.getStoredRolls.length) {
          this.handleOpeningStockModalClose();
          return null;
        }

        const method = !this.isEditMode ? 'post' : 'put';
        const url = !this.isEditMode ? `/color/${this.color.id}/current-stocks` : `/color/${this.color.id}/current-stocks/${this.modals.openingStock.values.id}`;
        const params = this.isEditMode ? this.modals.openingStock.values : this.getStoredRolls;

        axios[method](url, params)
          .then(() => {
            this.$toastr('success', this.form.alertMessage, 'Success!!');
            this.refreshStockPage();
          })
          .catch(() => {
            this.$toastr('error', this.form.alertMessage, 'Error!!')
          });
      },
      saveStock() {
        axios.put(`/color/${this.color.id}/stocks`, this.updatedStock)
          .then(() => {
            this.$toastr('success', this.form.alertMessage, 'Success!!');
            this.refreshStockPage();
          })
          .catch(() => {
            this.$toastr('error', this.form.alertMessage, 'Error!!')
          })
      },
      goNextPageHandler() {
        this.$refs.dynamicComponent.$validator.validateAll()
          .then(valid => {
            if(valid) {
              this.goNextPage();
            }
          });
      },
      goNextPage() {
        if(this.currentPageIndex === 1) {
          this.storeStockData();
        }
        this.currentPageIndex = this.currentPageIndex + 1;
      },
      goPrevPage() {
        this.currentPageIndex = this.currentPageIndex - 1;
      },
      valuesUpdateHandler(key, data) {
        this.modals.addStock[key] = data;
      },
      stockDataUpdateHandler(stockData) {
        this.modals.addStock.values = stockData;
      },
      saveFutureStock() {
        const payLoad = this.getFormattedData;
        this.enableLoading();
        axios.post(`/color/${this.color.id}/future-stocks`, payLoad)
          .then(() => {
            this.$toastr('success', this.form.alertMessage, 'Success!!');
            this.refreshStockPage();
          })
          .catch(() => {
            this.$toastr('error', this.form.alertMessage, 'Error!!')
          })
          .finally(this.disableLoading);
      },
      storeStockData() {
        this.newStock.push(this.modals.addStock.values);
        this.modals.addStock.values = {
          add_stock_id: null,
          quantity: null,
          unit: null,
          list_price: null,
          discount: null,
          delivery: null,
          tax: null,
          levy: null,
          sell_price: null,
          delivery_date: '',
        };
      },
      addNewItemHandler() {
        this.currentPageIndex = 0;
      },
      canGoNextPage() {
        if (this.currentPageIndex !== 0) {
          return true;
        }
        const { values } = this.modals.addStock;
        return values.quantity && values.list_price;
      },
      hideSearchModal() {
        this.modals.search.show = false;
      },
      searchStockModal() {
        this.modals.search.show = true;
        this.enableLoading();
        getSites({for: 'share-site'})
          .then(({ data }) => (this.sites = data.data))
          .catch(() => this.$toastr('error', 'failed to fetch sites', 'Error!!'))
          .finally(this.disableLoading);
      },
      fetchSuppliers(siteId) {
        getSuppliersBySite(siteId)
        .then(({ data }) => this.suppliersList = data.data)
        .catch(() => this.$toastr('error', 'failed to fetch', 'Error!!'));
      },
      fetchProduct(supplierId) {
        getProductsBySupplier(supplierId)
        .then(({ data }) => this.productsList = data.data)
        .catch(() => this.$toastr('error', 'failed to fetch', 'Error!!'));
      },
      fetchColors(productId) {
        getColorsByProduct(productId)
        .then(({ data }) => this.colorsList = data.data)
        .catch(() => this.$toastr('error', 'failed to fetch', 'Error!!'));
      },
      searchStock() {
        const color = this.modals.search.values.color;
        if (!color) {
          return;
        }
        window.location.href = `/color/${color}/stocks`;
      },
      refreshStockPage() {
        window.location.href = `/color/${this.color.id}/stocks`;
      },
      findColors(productId) {
        const product = this.products.find(product => product.id === productId);
        return product ? product.product_variants : [];
      },
      redirectToCurrentOrders(orderNumber) {
        window.location.href = `/current-orders/${orderNumber}`;
      },
      showAllocationModal() {
        this.modals.allocation.show = true;
      },
      cancelAllocation() {
        this.allocatingStock = {};
      },
      hideAllocationModal() {
        this.isEditMode = false;
        this.modals.allocation = { ...BASE_ALLOCATION };
      },
      currentOrFutureAllocation(allocationObj) {
        console.log(allocationObj);
        this.allocatingStock = { ...allocationObj, 'job_material_id': this.stock.ongoing_allocation_job_material_id ||  allocationObj.job_material_id};
        this.hideAllocationModal();
      },
      allocateCurrentStock(currentStockInfo) {
        if(Number(currentStockInfo.size) - Number(currentStockInfo.sold) === 0) {
          this.openErrorModal('CurrentStock');
        } else {
          this.selectedCurrentStock = currentStockInfo;
          this.openCurrentStockAllocationModal();
        }

      },
      openCurrentStockAllocationModal() {
        this.modals.allocateCurrentStock.show = true;
      },
      hideCurrentStockAllocation() {
        this.modals.allocateCurrentStock = { ...BASE_CURRENT_ALLOCATION };
        this.selectedCurrentStock = {};
      },
      totalSize(stockGroup) {
        return stockGroup.reduce((acc, val) => acc + Number(val.size) ,0)
      },
      total4Sale(stockGroup) {
        const totalSize = this.totalSize(stockGroup);
        const totalSold = this.totalSold(stockGroup);
        return totalSize - totalSold;
      },
      totalSold(stockGroup) {
        return stockGroup.reduce((acc, val) => acc + Number(val.sold) ,0)
      },
      fetchJobs() {
        return axios.get(`/api/sites/${this.supplier.site.id}/jobs`)
          .then(({ data }) => {
            this.jobs = data.data;
          })
          .catch(() => console.log('could not fetch job data'));
      },
      allocateStock({ size  }) {
        if (size) {
          const remaining = this.allocatingStock.amount - Number(size);
          if(remaining) {
            this.allocatingStock.amount = remaining.toFixed(2);
            return this.fetchCurrentStock();
          }

          if (this.isAllocationOngoing) {
            return window.location.href = `/jobs/${this.stock.ongoing_allocation_job_material_sale.job_id}/edit?page=${2}`;
          }

          return this.refreshStockPage();
        }
      },
      futureStockAllocated() {
        if (this.isAllocationOngoing) {
          return window.location.href = `/jobs/${this.stock.ongoing_allocation_job_material_sale.job_id}/edit?page=${2}`;
        }

        return this.refreshStockPage();
      },
      fetchCurrentStock() {
        this.enableLoading();
        getCurrentStockList(this.color.id)
          .then(({ data }) => {
            this.currentStocks = data.data;
          })
          .catch()
          .finally(this.disableLoading);
      },
      cancel() {
        this.cancelAllocation();
        this.isEditMode = false;
        this.isDeleteMode = false;
        this.isDispatchMode = false;
        this.isMoveMode = false;
        this.moveData = { ...BASE_MOVE_DATA };
        this.dispatchAllocationSeries = [];
      },
      openModal(type) {
        if (type) {
          this[`mount${type}`] = true;
        }
      },
      closeModal(type) {
        this.isEditMode = false;
        this.isDeleteMode = false;
        this.isDispatchMode = false;
        this.dispatchAllocationSeries = [];
        if (type) {
          this[`mount${type}`] = false;
        }
      },
      getAllocationFromDispatch(dispatch) {
        if (!dispatch.id) {
          return '&nbsp';
        }
        return dispatch.allocation_id ? dispatch.allocation : {};
      },
      getCurrentStockFromDispatch(dispatch, data) {
        if (!dispatch.id) {
          return '&nbsp';
        }
        const allocation = this.getAllocationFromDispatch(dispatch);
        return allocation.current_stock_id ? allocation.current_stock[data] : {};
      },
      getJobFromDispatch(dispatch) {
        if (!dispatch.id) {
          return '&nbsp';
        }
        return dispatch.job_id ? dispatch.job : {};
      }, 
      getJobNo(dispatch) {
        const job = this.getJobFromDispatch(dispatch);
        return job.site_id ? `${job.site.quote_prefix}${job.job_id}` : '';
      },
      redirectToJob(job) {
        if (!job.id) {
          return;
        }
        window.location.href = `/jobs/${job.id}/edit?page=2`;
      },
      clickedOnDispatch(dispatch) {
        const job = this.getJobFromDispatch(dispatch);
        this.redirectToJob(job);
      }
    },
  }
</script>

<style scoped>
.form-control {
  line-height: 24px !important;
}

.future-stock {
  max-height: 100px;
}
.background-black {
  background-color: black;
  color: white;
  width: fit-content;
}
.reorder-col {
  display: flex;
  align-items: center;
}
.reorder-item {
  background-color: white;
  width: 200px;
  display: inline-flex;
  align-items: center;
}
.text-blue {
  color: blue !important;
}
.text-red {
  color: red !important;
}
.text-green {
  color: green !important;
}
.total-info {
  display: inline-flex;
  flex-direction: column;
}
.width-100p {
  width: 100%;
}
.table-head {
  background-color: transparent !important;
  font-weight: bold;
  border: 0 !important;
}
.batch-list {
  direction: rtl;
  overflow-x: hidden;
  overflow-y: auto;
  max-height: 400px;
}
.batch-list * {
  direction: ltr;
}
.add-stock__area {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.disabled {
  cursor: not-allowed;
}
.menu-bar {
  display: flex;
  justify-content: space-between;
  width: 100%;
}
</style>
