<template>
  <modal title="Select a product range" @close="handleClose" :is-large="page === 1 ? false : true">
    <loading :loading="loading" />
    <template slot="modal-body">
      <template v-if="page === 1">
        <div class="row">
          <label class="col-3 text-right">Supplier</label>
          <div class="col-8">
            <drop-down
              placeholder="Select Supplier"
              v-model="selectedSupplier"
              :options="suppliers"
              label="trading_name"
              name="supplier"
              key="supplier"
              v-validate="'required'"
            />
            <label class="error">{{ errors.first('supplier') }}</label>
          </div>
        </div>
        <div class="row pt-3">
          <label class="col-3 text-right">Product</label>
          <div class="col-8">
            <drop-down
              ref="productDropDown"
              placeholder="Select Product"
              v-model="model.product_id"
              :options="products"
              name="product"
              key="product"
              v-validate="'required'"
            />
            <label class="error">{{ errors.first('product') }}</label>
          </div>
        </div>
        <div class="row pt-3">
          <label class="col-3 text-right">Pattern</label>
          <div class="col-8">
            <drop-down
              ref="patternDropDown"
              key="pattern"
              placeholder="Select Pattern"
              v-model="model.variant_id"
              :options="selectedVariantOptions"
              name="Pattern"
              v-validate="`required`"
            />
            <label class="error">{{ errors.first('Pattern') }}</label>
          </div>
        </div>
        <div class="row pt-3">
          <label class="col-3 text-right">Qty</label>
          <div class="col-3">
            <input
              class="form-control"
              type="number"
              v-model="model.quantity"
              name="quantity"
              v-validate="'required|decimal:2'"
            />
            <label class="error">{{ errors.first('quantity') }}</label>
          </div>
          <label class="col-2 text-right">List Price</label>
          <div class="col-3">
            <input
              class="form-control"
              type="number"
              v-model="model.unit"
              name="unit"
              v-validate="'required|decimal:2'"
            />
            <label class="error">{{ errors.first('unit') }}</label>
          </div>
        </div>
        <div class="row pt-3" v-show="isExtraField">
          <label class="col-3 text-right">Discount:</label>
          <div class="col-3">
            <input
              class="form-control"
              type="number"
              v-model="model.discount"
              name="discount"
              v-validate="'decimal:2'"
            />
            <label class="error">{{ errors.first('discount') }}</label>
          </div>
          <label class="col-2 text-right">Tax:</label>
          <div class="col-3">
            <input
              class="form-control"
              type="number"
              v-model="model.gst"
              name="tax"
              v-validate="'decimal:2'"
            />
            <label class="error">{{ errors.first('tax') }}</label>
          </div>
        </div>
        <div class="row pt-3" v-show="isExtraField">
          <label class="col-3 text-right">Levy:</label>
          <div class="col-3">
            <input
              class="form-control"
              type="number"
              v-model="model.levy"
              name="levy"
              v-validate="'decimal:2'"
            />
            <label class="error">{{ errors.first('levy') }}</label>
          </div>
        </div>
        <label class="pt-2">{{ selectedProduct.price_base }}</label>
      </template>
      <template v-else>
        <div class="row">
          <label>
            {{ selectedProduct.name }} <br/>
            {{ selectedProduct.trading_name }} <br/>
            {{ selectedVariant.name }}</label>
        </div>
        <div class="row pt-2 d-flex align-items-baseline">
          <label class="col-3 text-right">CURRENT STOCK</label>
          <label class="col-1">&nbsp;</label>
          <div class="col-7">
            <drop-down
              key="selectedCurrentStock"
              :options="current_stock_options"
              v-model="selectedCurrentStock"
              name="current stock"
              ref="stockCurrent"
              :return-object="true"
              label="selling_price"
              :allow-empty="true"
            >
              <template slot="singleLabel" slot-scope="{ data }">{{ '$' + data.selling_price  + ' RRP, Item: ' + data.roll_no  + ', Batch: ' + data.batch + ', Age: ' + data.received_date + ', 4 Sale: ' + (data.size - data.sold)}}</template>
              <template slot="option" slot-scope="{ data }"><span>{{ '$' + data.selling_price  + ' RRP, Item: ' + data.roll_no  + ', Batch: ' + data.batch + ', Age: ' + data.received_date + ', 4 Sale: ' + (data.size - data.sold)}}</span></template>
            </drop-down>
          </div>
        </div>
        <div class="row pt-3">
          <label class="col-3 text-right">Warehoused: {{ stock.total_current_stock }}</label>,
          <label class="col-3">Allocated: {{ stock.total_current_stock - stock.current_stock_total_for_sell }}</label>
          <label class="col-3">Free to Sell: {{ stock.current_stock_total_for_sell }}</label>
        </div>
        <div class="row pt-2 d-flex align-items-baseline">
          <label class="col-3 text-right">FUTURE STOCK</label>
          <label class="col-1">&nbsp;</label>
          <div class="col-7">
            <drop-down
              :options="future_stock_options"
              v-model="selectedFutureStock"
              key="futureStock"
              name="future stock"
              label="list_price"
              :return-object="true"
              :allow-empty="true"
            >
              <template slot="singleLabel" slot-scope="{ data }">{{ '$' + (data.sell_price || 0)  + ' RRP per ' + (data.unit || 0)  + ', Ordered: 0, 4 Sale: ' + (data.quantity - data.sold) + ', Due on: ' + data.delivery_date || ''}}</template>
              <template slot="option" slot-scope="{ data }"><span>{{ '$' + (data.sell_price || 0)  + ' RRP per ' + (data.unit || 0)  + ', Ordered: 0, 4 Sale: ' + (data.quantity - data.sold) + ', Due on: ' + data.delivery_date || ''}}</span></template>
            </drop-down>
            <label class="error" v-if="customValidationError">{{ customValidationError }}</label>
          </div>
        </div>
        <div class="row pt-4">
          <label class="col-3 text-right">On Order: {{ stock.total_future_stock }}</label>,
          <label class="col-3">Back Ordered: {{ stock.total_future_stock - stock.future_stock_total_for_sell }}</label>
          <label class="col-3">Free to Sell: {{ stock.future_stock_total_for_sell }}</label>
        </div>
        <div class="row pt-3">
          <label class="col-3 text-right">From Price List...</label>
          <label class="col-1">&nbsp;</label>
          <label class="col-5">$0.00 inc. per </label>
        </div>
        <label class="row pt-4">
          To use the Price List cost simply activate the 'Next >' button without other selections. <br/>
          You can select your cost from any one of listed Current OR Future Stock.
        </label>
      </template>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="addNewProduct">Add</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>

import { Validator } from 'vee-validate';
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin } from '../../../../common/mixins';
import { getSuppliersBySite, getProductsBySupplier } from '../../../api/calls';


export default {
  name: "SelectProduct",
  mixins: [LoadingMixin],
  components: {
    Modal,
    DropDown
  },
  props: {
    siteId: {
      type: Number,
      required: true
    },
    preSelectedVariants: {
      type: Array,
      default: () => [],
    },
    isStockDataNeeded: {
      type: Boolean,
      default: false
    },
    isExtraField: {
      type: Boolean,
      default: true
    },
  },
  data: () => ({
    model: {
      product_id: "",
      variant_id: "",
      quantity: "",
      unit: "",
      material_from: 'P'
    },
    selectedFutureStock: {},
    selectedCurrentStock: {},
    current_stock_options: [],
    future_stock_options: [],
    stock: {},
    products: [],
    suppliers: [],
    page: 1,
    customValidationError: '',
    selectedSupplier: '',
  }),
  watch: {
    selectedSupplier(value) {
      this.fetchProductsBySupplier(value);
      this.model.product_id = null;
      this.model.variant_id = null;
      this.$refs.productDropDown.reset();
      this.$refs.patternDropDown.reset();
    },
    'model.product_id'(value) {
      this.model.variant_id = null;
      this.$refs.patternDropDown.reset();
      const product = this.products.find(product => product.id === value) || {};
      this.model.unit = product.list_cost;
      this.model.gst = product.gst;
      this.model.levy = product.levy;
      this.model.discount = product.discount;
      this.model.unit_sell = product.retail_sell ? product.retail_sell.with_gst : 0;
    },
  },
  computed: {
    productAndSupplierList() {
      return this.products.map(product => ({
        ...product,
        optionName: `${product.name} from ${product.supplier.trading_name}`
      }));
    },
    selectedProduct() {
      return (
        this.products.find(product => product.id === this.model.product_id) ||
        {}
      );
    },
    selectedVariantOptions() {
      return this.selectedProduct.product_variants || [];
    },
    selectedVariant() {
      return this.selectedVariantOptions.find(variant => variant.id === this.model.variant_id) || {};
    },
    total() {
      return this.model.quantity * this.model.unit;
    },
  },
  created() {
    // this.fetchProducts();
    this.fetchSuppliersBySite();
  },
  methods: {
    fetchSuppliersBySite() {
      this.enableLoading();
      getSuppliersBySite(this.siteId)
        .then(({ data }) => (this.suppliers = data.data))
        .catch(error => this.$toastr("error", error.message, "Error!!"))
        .finally(this.disableLoading);
    },
    fetchProductsBySupplier(supplierId) {
      this.enableLoading();
      getProductsBySupplier(supplierId)
        .then(({ data }) => (this.products = data.data))
        .catch(error => this.$toastr("error", error.message, "Error!!"))
        .finally(this.disableLoading);
    },
    fetchProducts() {
      this.enableLoading();
      axios
        .get(`/api/sites/${this.siteId}/products`)
        .then(({ data }) => (this.products = data.data))
        .catch(error => this.$toastr("error", error.message, "Error!!"))
        .finally(this.disableLoading);
    },
    handleClose() {
      this.$emit("close");
    },
    addNewProduct() {
      this.validate().then(valid => {
        if (valid && !this.customValidationError) {
          if (this.page === 1 && this.isStockDataNeeded) {
            this.fetchStockData();
          } else {
            this.emitProductAdd();
          }
        }
      });
    },
    validate() {
      if (
        this.selectedCurrentStock && this.selectedCurrentStock.id 
        && this.selectedFutureStock && this.selectedFutureStock.id
      ) {
        this.customValidationError = 'Only Current Sock or Future Stock can be selected, but not both';
      } else {
        this.customValidationError = '';
      }
      return this.$validator.validateAll();
    },
    fetchStockData() {
      this.enableLoading();
      axios.get(`/api/color/${this.model.variant_id}/stocks`)
        .then(({ data }) => {
          const stock = data.data.stock || {};
          if (stock.current_stock_total_for_sell || stock.future_stock_total_for_sell) {
            this.stock = stock;
            this.future_stock_options = data.data.futureStock;
            this.current_stock_options = data.data.currentStock;
            this.page = 2;
          } else {
            this.emitProductAdd();
          }
        })
        .catch (error => console.log('could not fetch stock data.', error))
        .finally(() => {
          this.disableLoading();
        });
    },
    emitProductAdd() {
      let unitPrice = this.model.unit;
      if (this.selectedCurrentStock && this.selectedCurrentStock.selling_price) {
        this.model.material_from = 'S';
        unitPrice = this.selectedCurrentStock.selling_price;
      } else if (this.selectedFutureStock && this.selectedFutureStock.list_price) {
        this.model.material_from = 'F';
        unitPrice = this.selectedFutureStock.list_price;
      }
      let cost = Number(unitPrice) * Number(this.model.quantity);
      // if (this.selectedProduct.supplier.delivery) {
      //   cost = cost + Number(this.selectedProduct.supplier.delivery);
      // }
      if (this.model.gst) {
        cost = cost + ((cost * this.model.gst) / 100);
      }
      if (this.model.levy) {
        cost = cost + ((cost * this.model.levy) / 100);
      }
      if (this.model.discount) {
        cost = cost - ((cost * this.model.discount) / 100);
      }
      this.model.total = cost.toFixed(2);

      this.$emit("product", {
        ...this.model,
        upc: this.selectedProduct.upc,
        product_name: this.selectedProduct.name,
        variant_name: this.selectedVariant.name,
        unit: unitPrice,
        supplier_name: this.selectedProduct.supplier.trading_name,
        supplier_id: this.selectedProduct.supplier_id,
      });

      let deliveryCharge = this.selectedProduct.supplier.delivery;
      let totalDeliveryCost = deliveryCharge
      if (this.model.gst) {
        totalDeliveryCost = Number(deliveryCharge) + ((Number(deliveryCharge) * this.model.gst) / 100);
      }
      if (this.model.material_from === 'P' && deliveryCharge) {
        this.$emit("product", {
          quantity: 1,
          unit: deliveryCharge,
          unit_sell: deliveryCharge,
          product_name: "Bailing/Delivery",
          variant_name: "",
          total: totalDeliveryCost,
          gst: this.model.gst,
          supplier_name: this.selectedProduct.supplier.trading_name,
          supplier_id: this.selectedProduct.supplier_id,
        })
      }

      this.handleClose();
    },
    emit(type, data = {}) {
      if (type) {
        this.$emit(type, data);
      }
      this.handleClose();
    }
  }
};
</script>
