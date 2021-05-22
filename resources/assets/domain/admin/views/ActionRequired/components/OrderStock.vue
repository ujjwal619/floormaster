<template>
  <modal :title="getTitle"
         :is-large="false"
         @close="handleClose">
    <template slot="modal-body">
      <div class="form-group">
        <div class="col-lg-8">
          <div class="row pb-2" v-if="currentPageIndex < 3">
            <label class="col-lg-4" style="text-align: right">Supplier:</label>
            <label class="col-lg-8">{{ supplier.trading_name }}</label>
          </div>
          <div class="row pb-2" v-if="currentPageIndex < 2">
            <label class="col-lg-4" style="text-align: right">Range:</label>
            <label class="col-lg-8">{{ product.name }}</label>
          </div>
          <div class="row pb-2" v-if="currentPageIndex < 2">
            <label class="col-lg-4" style="text-align: right">Colour:</label>
            <label class="col-lg-8">{{ color.name }}</label>
          </div>
        </div>
      </div>
      <component
        ref="dynamicComponent"
        :data="futureStock.values"
        :is="currentPage"
        :stock-data="futureStock"
        :supplier="supplier"
        :product="product"
        :stock-list="newStock"
        :color="color"
        @updated:values="valuesUpdateHandler"
        @updated:stock-data="stockDataUpdateHandler"
        @add:new-item="addNewItemHandler"
      />
    </template>
    <template slot="modal-footer">
      <button
        v-if="isFirstPage"
        type="button"
        class="btn action-buttons"
        @click="handleClose"
      >Cancel
      </button>
      <template v-else>
        <button
          v-if="currentPageIndex !== 2"
          type="button"
          class="btn action-buttons"
          @click="goPrevPage"
        > < Back
        </button>
      </template>
      <button
        v-if="!isLastPage"
        type="button"
        class="btn action-buttons"
        @click="goNextPageHandler"
      >Next >
      </button>
      <button
        v-else
        type="button"
        class="btn action-buttons"
        @click="saveFutureStock"
      >Finish
      </button>
    </template>
    <loading :loading="loading" />
  </modal>
</template>

<script>
  import { LoadingMixin } from "../../../../common/mixins";
  import Page1 from '../../Stocks/Page1'
  import Page2 from '../../Stocks/Page2'
  import Page3 from '../../Stocks/Page3'
  import Page4 from '../../Stocks/Page4'
  import Page5 from '../../Stocks/Page5'
  import Page6 from '../../Stocks/Page6'
  import Modal from "../../../../common/components/Modal/Modal";
import { getSupplierById } from '../../../api/calls';

  const PAGE_TITLE = [
    'Add Stock Order Item',
    'Making Stock Order',
    'Placing Stock Order',
    'Delivery Address',
    "New Order - Supplier's Reference",
    'New Stock Order Placed'
  ];
  const BASE_ADD_STOCK = {
    interim_order_number: null,
    supplier_reference: '',
    delivery_address: {},
    supplier_details: {
      placed_with: '',
    },
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

  export default {
    name: "OrderStock",
    mixins: [LoadingMixin],
    components: {
      Page1,
      Page2,
      Page3,
      Page4,
      Page5,
      Page6,
      Modal,
    },
    props: {
      selectedMaterialForActing: {
        type: Object,
        default: () => {}
      },
    },
    data: () => ({
      currentPageIndex: 0,
      pageList: [
        'Page1', 'Page2', 'Page3', 'Page4', 'Page5', 'Page6'
      ],
      newStock: [],
      supplier: {},
      futureStock: { ...BASE_ADD_STOCK },
    }),
    computed: {
      product() {
        return { name: this.selectedMaterialForActing.product_name };
      },
      color() {
        return { name: this.selectedMaterialForActing.variant_name };
      },
      currentPage() {
        return this.pageList[this.currentPageIndex];
      },
      getTitle() {
        return PAGE_TITLE[this.currentPageIndex];
      },
      isFirstPage() {
        return this.currentPageIndex === 0;
      },
      isLastPage() {
        return this.currentPageIndex === (this.pageList.length - 1);
      },
    },
    created() {
      this.fetchSupplierById(this.selectedMaterialForActing.supplier_id);
    },
    methods: {
      handleClose() {
        this.$emit("close");
      },
      valuesUpdateHandler(key, data) {
        this.futureStock[key] = data;
      },
      stockDataUpdateHandler(stockData) {
        this.futureStock.values = stockData;
      },
      addNewItemHandler() {
        this.currentPageIndex = 0;
      },
      goNextPage() {
        if(this.currentPageIndex === 1) {
          this.storeStockData();
        }
        this.currentPageIndex = this.currentPageIndex + 1;
      },
      storeStockData() {
        this.newStock.push({ ...this.futureStock.values, job_material_id: this.selectedMaterialForActing.id});
        this.futureStock.values = {
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
      goPrevPage() {
        this.currentPageIndex = this.currentPageIndex - 1;
      },
      goNextPageHandler() {
        this.$refs.dynamicComponent.$validator.validateAll()
          .then(valid => {
            if(valid) {
              this.goNextPage();
            }
          });
      },
      saveFutureStock() {
        this.enableLoading();
        const payload = this.getFormattedDataForOrderStock();
        axios.post(`/api/color/${this.selectedMaterialForActing.variant_id}/order-stock-from-job/${this.selectedMaterialForActing.id}`, payload)
          .then(({ data }) => {
            this.$toastr('success', data.message, 'Success!!');
            this.$emit('ordered');
          })
          .catch((data) => {
            this.$toastr('error', data.message, 'Error!!')
          })
          .finally(() => {
            this.disableLoading();
            this.handleClose();
          });
      },
      fetchSupplierById(id) {
        this.enableLoading();
        getSupplierById(id)
          .then(({ data }) => {
            this.supplier = data.data;
            this.futureStock.values.quantity = Number(this.selectedMaterialForActing.quantity) - Number(this.selectedMaterialForActing.allocated);
            this.futureStock.values.list_price = this.selectedMaterialForActing.unit;
            this.futureStock.values.discount = this.selectedMaterialForActing.discount;
            this.futureStock.values.tax = this.selectedMaterialForActing.gst;
            this.futureStock.values.levy = this.selectedMaterialForActing.levy;
            this.futureStock.values.delivery = data.data.delivery || '';
          })
          .catch((data) => {
            this.$toastr('error', data.message, 'Error!!')
          })
          .finally(() => {
            this.disableLoading();
          });
      },
      getFormattedDataForOrderStock() {
        return {
          futureStocks: [...this.newStock],
          supplier_details: this.futureStock.supplier_details,
          delivery_address: this.futureStock.delivery_address || {},
          supplier_reference: this.futureStock.supplier_reference,
          interim_order_number: this.futureStock.interim_order_number,
        };
      },
    },
  }
</script>

<style scoped>

</style>
