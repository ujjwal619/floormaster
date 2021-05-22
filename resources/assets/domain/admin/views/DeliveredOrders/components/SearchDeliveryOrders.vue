<template>
  <modal title="Order Search" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <label>Search By Store:</label>
        <drop-down
          ref="searchStore"
          :options="sites"
          placeholder="Search By Store"
          v-model="selectedSite"
        />
      </div>
      <div class="row pt-3">
        <label>Search By Supplier:</label>
        <drop-down
          ref="searchSupplier"
          :options="suppliers"
          placeholder="Search By Supplier"
          v-model="selectedSupplier"
        />
      </div>
      <div class="row pt-3">
        <label>Search By Product:</label>
        <drop-down
          ref="searchProduct"
          :options="products"
          placeholder="Search By Product"
          v-model="selectedProduct"
        />
      </div>
      <div class="row pt-3">
        <label>Search By Color:</label>
        <drop-down
          ref="searchColor"
          :options="colors"
          placeholder="Search By Color"
          v-model="selectedColor"
        />
      </div>
      <div class="row pt-3">
        <label>Select Order: </label>
        <drop-down
          ref="selectOrder"
          placeholder="Search Order"
          v-model="currentOrderId"
          :options="deliveryOrders"
          v-validate="'required'"
          name="order"
        >
          <template slot="singleLabel" slot-scope="{ data }">{{ data.product_name + ', ' + data.color_name + ' ... ' + (data.future_stock_pending || '0') + (data.future_stock_unit || ' ') + 'Due. ' + (data.job_no ? `C/O for: ${data.job_client_name},${data.job_no}` : ' ') + ' O/No:' + data.id }}</template>
          <template slot="option" slot-scope="{ data }"><span>{{ data.product_name + ', ' + data.color_name + ' ... ' + (data.future_stock_pending || '0') + (data.future_stock_unit || ' ') + 'Due. ' + (data.job_no ? `C/O for: ${data.job_client_name},${data.job_no}` : ' ') + ' O/No:' + data.id }}</span></template>
        </drop-down>
        <label class="error pt-1">{{ errors.first('order') }}</label>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="goButtonHandler">Go</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { 
  getSites, 
  getDeliveryOrders, 
  getSuppliers, 
  getProducts, 
  getColors
} from '../../../api/calls'
import { LoadingMixin } from '../../../../common/mixins'

export default {
  name: "SearchDeliveryOrders",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  data: () => ({
    currentOrderId: "",
    selectedSite: '',
    selectedSupplier: '',
    selectedProduct: '',
    selectedColor: '',
    searchParams: {},
    deliveryOrders: [],
    sites: [],
    suppliers: [],
    products: [],
    colors: [],
  }),
  watch: {
    selectedSite(value) {
      if (value) {
        this.selectedSupplier = '';
        this.selectedProduct = '';
        this.selectedColor = ''
        this.currentOrderId = '';
        this.$refs.searchSupplier.reset();
        this.$refs.searchProduct.reset();
        this.$refs.searchColor.reset();
        this.$refs.selectOrder.reset();
        this.searchParams = { 'site_id': value};
        this.fetchSuppliers();
        this.fetchProducts();
        this.fetchColors();
        this.fetchDeliveryOrders();
      }
    },
    selectedSupplier(value) {
      if (value) {
        this.selectedProduct = ''
        this.selectedColor = ''
        this.currentOrderId = ''
        this.$refs.searchProduct.reset();
        this.$refs.searchColor.reset();
        this.$refs.selectOrder.reset();
        this.searchParams = { ...this.searchParams, 'supplier_id': value};
        this.fetchProducts();
        this.fetchColors();
        this.fetchDeliveryOrders();
      }
    },
    selectedProduct(value) {
      if (value) {
        this.selectedColor = ''
        this.currentOrderId = ''
        this.$refs.selectOrder.reset();
        this.$refs.searchColor.reset();
        this.searchParams = { ...this.searchParams, 'product_id': value};
        this.fetchColors();
        this.fetchDeliveryOrders();
      }
    },
    selectedColor(value) {
      if (value) {
        this.currentOrderId = ''
        this.$refs.selectOrder.reset();
        this.searchParams = { ...this.searchParams, 'color_id': value};
        this.fetchDeliveryOrders();
      }
    },
  },
  created() {
    this.fetchDeliveryOrders();
    this.fetchSites();
    this.fetchSuppliers();
    this.fetchProducts();
    this.fetchColors();
  },
  methods: {
    fetchSites() {
      this.enableLoading();
      getSites()
        .then(({ data }) => {
          this.sites = data.data;
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },
    fetchDeliveryOrders() {
      this.enableLoading();
      getDeliveryOrders(this.searchParams)
        .then(({ data }) => {
          this.deliveryOrders = data.data;
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },
    fetchSuppliers() {
      this.enableLoading();
      getSuppliers(this.searchParams)
        .then(({ data }) => {
          this.suppliers = data.data;
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },
    fetchProducts() {
      this.enableLoading();
      getProducts(this.searchParams)
        .then(({ data }) => {
          this.products = data.data;
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },
    fetchColors() {
      this.enableLoading();
      getColors(this.searchParams)
        .then(({ data }) => {
          this.colors = data.data;
        })
        .catch(error => console.log(error))
        .finally(() => this.disableLoading());
    },
    goButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          this.$emit('selected', this.currentOrderId);
          this.handleClose();
        }
      });
    },
    validate() {
      return this.$validator.validate();
    },
    handleClose() {
      this.$emit("close");
    }
  }
};
</script>
