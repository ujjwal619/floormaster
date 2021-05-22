<template>
  <modal title="Edit Material Product" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <label class="col-3 text-right">Supplier:</label>
        <label class="col-8">{{ materialProduct.supplier_name }}</label>
      </div>
      <div class="row pt-3">
        <label class="col-3 text-right">Product:</label>
        <label class="col-8">{{ materialProduct.product_name }}</label>
      </div>
      <div class="row pt-3">
        <label class="col-3 text-right">Pattern:</label>
        <label class="col-8">{{ materialProduct.variant_name }}</label>
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
      <div class="row pt-3">
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
      <div class="row pt-3">
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
        <label class="col-2 text-right">Unit Sell:</label>
        <div class="col-3">
          <input
            class="form-control"
            type="number"
            v-model="model.unit_sell"
            name="tax"
            v-validate="'decimal:2'"
          />
          <label class="error">{{ errors.first('tax') }}</label>
        </div>
      </div>
      <div class="row pt-3">
        <template v-if="isExtraField">
          <label class="col-3 text-right">Sell Price:</label>
          <div class="col-3">
            <input
              class="form-control"
              type="number"
              v-model="model.sell_price"
              name="sell price"
              v-validate="'decimal:2'"
            />
            <label class="error">{{ errors.first('sell price') }}</label>
          </div>
        </template>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="updateMaterialProduct">Update</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>
<script>

import { Validator } from 'vee-validate';
import Modal from "./Modal/Modal";
import { LoadingMixin } from '../mixins';

export default {
  name: "EditMaterialProduct",
  mixins: [LoadingMixin],
  components: {
    Modal,
  },
  props: {
    isExtraField: {
      type: Boolean,
      default: true
    },
    materialProduct: {
      type: Object,
      required: true,
    },
  },
  created() {
    this.model = { ...this.materialProduct };
    if (this.model.product_id) {
      axios.get(`/api/products/${this.model.product_id}`)
        .then(({ data }) => {
          this.model.upc = data.data.upc;
        })
    }
  },
  data: () => ({
    model: {
      quantity: "",
      unit: "",
    },
  }),
  methods: {
    handleClose() {
      this.$emit("close");
    },
    updateMaterialProduct() {
      this.validate().then(valid => {
        if (valid) {
          this.emitMaterialProductUpdate();
        }
      });
    },
    validate() {
      return this.$validator.validateAll();
    },
    emitMaterialProductUpdate() {
      let unitPrice = this.model.unit;
      let cost = Number(unitPrice) * Number(this.model.quantity);
      if (this.model.gst) {
        cost = cost + ((cost * this.model.gst) / 100);
        console.log(Number(unitPrice), Number(this.model.quantity), cost)
      }
      if (this.model.levy) {
        cost = cost + ((cost * this.model.levy) / 100);
      }
      if (this.model.discount) {
        cost = cost - ((cost * this.model.discount) / 100);
      }
      this.model.total = cost.toFixed(2);

      this.emit("product", {
        ...this.model,
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
