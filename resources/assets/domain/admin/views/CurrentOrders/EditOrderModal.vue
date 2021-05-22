<template>
  <modal title="Edit Order Item" @close="handleClose">
    <template slot="modal-body">
      <div class="form-group row">
        <div class="col-lg-8">
          <div class="row pb-2">
            <label class="col-lg-4" style="text-align: right">Order No:</label>
            <label class="col-lg-4">{{ model.order_number }}</label>
          </div>
          <div class="row pb-2">
            <label class="col-lg-4" style="text-align: right">Range:</label>
            <label class="col-lg-4">{{ productName }}</label>
          </div>
          <div class="row pb-2">
            <label class="col-lg-4" style="text-align: right">Color:</label>
            <label class="col-lg-4">{{ color.name || '' }}</label>
          </div>
          <div class="row pb-2">
            <label class="col-lg-4" style="text-align: right">Quantity:</label>
            <input class="col-lg-8 form-control" type="number" v-model="model.quantity">
          </div>
          <div class="row pb-2">
            <label class="col-lg-4" style="text-align: right">Unit:</label>
            <input class="col-lg-8 form-control" type="text" v-model="model.unit">
          </div>
          <div class="row pb-2">
            <label class="col-lg-4" style="text-align: right">List Unit Cost:</label>
            <input class="col-lg-8 form-control" type="number" v-model="model.list_price">
          </div>
          <div class="row pb-2">
            <label class="col-lg-4" style="text-align: right">Discount%:</label>
            <input class="col-lg-8 form-control" type="number" v-model="model.discount">
          </div>
          <div class="row pb-2">
            <label class="col-lg-4" style="text-align: right">Tax%:</label>
            <input class="col-lg-8 form-control" type="number" v-model="model.tax">
          </div>
          <div class="row pb-2">
            <label class="col-lg-4" style="text-align: right">Baling/Delivery:</label>
            <input class="col-lg-8 form-control" type="text" v-model="model.delivery">
          </div>
          <div v-if="supplier.levy_account" class="row pb-2">
            <label class="col-lg-4" style="text-align: right">Levy%:</label>
            <input class="col-lg-8 form-control" type="text" v-model="model.levy">
          </div>
          <br>
          <div class="row pb-2">
            <label class="col-lg-4" style="text-align: right">Delivery Date:</label>
            <input 
              class="col-lg-8 form-control" 
              type="date" 
              v-model="model.delivery_date"
              name="delivery date" 
              v-validate="{ required: true, date_between: fiscalYearDateRangeForValidation }"
            >
            <label
              class="error"
              v-if="errors.firstByRule('delivery date', 'required')"
            >The delivery date field is required.</label>
            <label
              class="error"
              v-if="errors.firstByRule('delivery date', 'date_format')"
            >The delivery date field is required.</label>
            <label
              class="error"
              v-if="errors.firstByRule('delivery date', 'date_between')"
            >The delivery date field must be between {{ startOfFiscalYear }} and {{ endOfFiscalYear }}.</label>
          </div>
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button
        type="button"
        class="btn action-buttons"
        :class="{ 'disabled' : stopEditFinish }"
        :disabled="stopEditFinish"
        @click="handleFinished"
      >Finished</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../common/components/Modal/Modal";
import axios from "axios";
import {
  getViewFiscalYear,
  getFiscalYear,
  getFiscalYearDateRangeForValidation,
  formatViewDate
} from "../../../common/utitlities/helpers";

const EDIT_RULES = ["quantity", "list_price", "delivery_date"];

export default {
  name: "EditOrderModal",
  components: {
    Modal
  },
  props: {
    orderData: {
      type: Object,
      required: true
    }
  },
  data: () => ({
    model: {}
  }),
  computed: {
    color() {
      return this.model.color || {};
    },
    product() {
      return this.color.product || {};
    },
    supplier() {
      return this.product.supplier || {};
    },
    productName() {
      return this.product.name || this.model.product_name;
    },
    startOfFiscalYear() {
      return formatViewDate(getFiscalYear());
    },
    endOfFiscalYear() {
      return formatViewDate(getFiscalYear("end"));
    },
    fiscalYearDateRangeForValidation() {
      return getFiscalYearDateRangeForValidation();
    },
    stopEditFinish() {
      const isNotValid = EDIT_RULES.some(key => !this.model[key]);
      return isNotValid;
    }
  },
  created() {
    this.model = { ...this.orderData };
  },
  methods: {
    handleClose() {
      this.$emit("close");
    },
    validate() {
      return this.$validator.validateAll();
    },
    handleFinished() {
      this.validate().then(valid => {
        if (valid) {
          const payLoad = { ...this.model };
          axios
            .put(`/future-stocks/${this.model.id}`, payLoad)
            .then(() => {
              this.$toastr(
                "success",
                "Successfully updated future stock",
                "Success!!"
              );
              this.$emit('updated');
            })
            .catch(() => {
              this.$toastr("error", "Could not update future stock", "Error!!");
            });
        }
      });
    }
  }
};
</script>
