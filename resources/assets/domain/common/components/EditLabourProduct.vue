<template>
  <modal title="Edit Labour Product" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <label class="col-3 text-right">Labour</label>
        <div class="col-3">
          <input
            class="form-control"
            type="text"
            v-model="model.product"
            name="labour"
            v-validate="'required'"
          />
          <label class="error">{{ errors.first('labour') }}</label>
        </div>
        <label class="col-2 text-right">Quantity</label>
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
      </div>
      <div class="row pt-3">
        <label class="col-3 text-right">Unit:</label>
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
        <label class="col-2 text-right">Charge @:</label>
        <template v-show="isExtraField">
          <div class="col-3">
            <input
              class="form-control"
              type="number"
              v-model="model.charge"
              name="charge"
              v-validate="'decimal:2'"
            />
            <label class="error">{{ errors.first('charge') }}</label>
          </div>
        </template>
      </div>
      <div class="row pt-3">
        <label class="col-3 text-right">Tax:</label>
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
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="updateLabourProduct">Update</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>
<script>

import { Validator } from 'vee-validate';
import Modal from "./Modal/Modal";
import { LoadingMixin } from '../mixins';

export default {
  name: "EditLabourProduct",
  mixins: [LoadingMixin],
  components: {
    Modal,
  },
  props: {
    isExtraField: {
      type: Boolean,
      default: true
    },
    labourProduct: {
      type: Object,
      required: true,
    },
  },
  created() {
    this.model = { ...this.labourProduct };
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
    updateLabourProduct() {
      this.validate().then(valid => {
        if (valid) {
          this.emitLabourProductUpdate();
        }
      });
    },
    validate() {
      return this.$validator.validateAll();
    },
    emitLabourProductUpdate() {
      let unitPrice = this.model.unit;
      let cost = Number(unitPrice) * Number(this.model.quantity);
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
