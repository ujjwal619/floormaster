<template>
  <modal title="Select a product range" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <template v-if="page === 1">
        <div class="row">
          <label class="col-3 text-right">Product and Supplier</label>
          <div class="col-8">
            <drop-down
              placeholder="Select Product & Supplier"
              v-model="model.product_id"
              :options="productAndSupplierList"
              label="optionName"
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
              key="pattern"
              placeholder="Select Pattern"
              v-model="model.variant_id"
              :options="selectedVariantOptions"
              name="Pattern"
              v-validate="`required|excluded:${preSelectedVariants}`"
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
              v-validate="'required|numeric|decimal:2'"
            />
            <label class="error">{{ errors.first('quantity') }}</label>
          </div>
          <label class="col-2 text-right">Unit Charge</label>
          <div class="col-3">
            <input
              class="form-control"
              type="number"
              v-model="model.unit"
              name="unit"
              v-validate="'required|numeric|decimal:2'"
            />
            <label class="error">{{ errors.first('unit') }}</label>
          </div>
        </div>
        <div class="row pt-3">
          <label class="col-3 text-right">Total</label>
          <input class="col-8 form-control" type="number" disabled :value="total" />
        </div>
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
              key="current_stock"
              :options="current_stock_options"
              v-model="model.current_stock"
              name="current stock"
              v-validate="'required'"
            />
            <label class="error">{{ errors.first('current stock') }}</label>
          </div>
        </div>
        <div class="row pt-3">
          <label class="col-3 text-right">Warehoused: 30</label>
          <label class="col-3">Allocated: 10</label>
          <label class="col-3">Free to Sell: 20</label>
        </div>
        <div class="row pt-2 d-flex align-items-baseline">
          <label class="col-3 text-right">FUTURE STOCK</label>
          <label class="col-1">&nbsp;</label>
          <div class="col-7">
            <drop-down
              :options="future_stock_options"
              v-model="model.future_stock"
              name="future stock"
              v-validate="'required'"
            />
            <label class="error">{{ errors.first('future stock') }}</label>
          </div>
        </div>
        <div class="row pt-4">
          <label class="col-3 text-right">On Order: 0</label>
          <label class="col-3">Back Ordered: 2</label>
          <label class="col-3">Free to Sell: -2</label>
        </div>
        <div class="row pt-3">
          <label class="col-3 text-right">From Price List...</label>
          <label class="col-1">&nbsp;</label>
          <label class="col-5">$1.00 inc. per </label>
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
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin } from '../../../../common/mixins';

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
  },
  data: () => ({
    model: {
      product_id: "",
      variant_id: "",
      quantity: "",
      unit: "",
      future_stock: '',
      current_stock: '',
    },
    current_stock_options: [],
    future_stock_options: [],
    products: [],
    page: 1,
  }),
  computed: {
    productAndSupplierList() {
      return this.products.map(product => ({
        ...product,
        optionName: `${product.name} - ${product.supplier.trading_name}`
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
    }
  },
  created() {
    this.fetchProducts();
  },
  methods: {
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
        if (valid) {
          if (page === 1) {
            this.fetchStockData();
          } else {
            this.emitProductAdd();
          }
        }
      });
    },
    validate() {
      return this.$validator.validateAll();
    },
    fetchStockData() {
      this.enableLoading();
      // @manjul create an api for fetching current and future stock and fix the url below
      axios.get(`/stock/${this.model.product_id}/variant_id`)
        .then(({ data }) => {
          if (data.future_stock.length && data.current_stock.length) {
            this.future_stock_options = data.future_stock;
            this.current_stock_options = data.current_stock;
            this.page = 2;
          } else {
            this.emitProductAdd();
          }
        })
        .catch (error => this.$toastr("error", 'Failed to load stock data', "Error!!"))
        .finally(this.disableLoading);
    },
    emitProductAdd() {
      this.emit("product", {
        ...this.model,
        product_name: this.selectedProduct.name,
        variant_name: this.selectedVariant.name,
        total: this.total
      });
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
