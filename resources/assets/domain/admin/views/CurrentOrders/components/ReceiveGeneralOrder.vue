<template>
  <modal title="Receive General Order Item" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <label class="col-3 text-right">O/No:</label>
        <div class="col-7">
          {{currentOrder.id}}
        </div>
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right">Qty Ordered:</label>
        <div class="col-7">
          {{displayNumber(stockData.quantity - stockData.received)}}
        </div>
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right">Supplier:</label>
        <div class="col-7">
          {{ supplierName }}
        </div>
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right">Product:</label>
        <div class="col-7">
          {{ productName }}
        </div>
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right">Already Received:</label>
        <div class="col-7">
          {{ stockData.received }}
        </div>
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right">Receipt Quantity:</label>
        <div class="col-7">
          <input
            class="form-control"
            type="number"
            v-model="model.size"
            name="receipt quantity"
          />
          <label class="error">{{ errors.first('receipt quantity') }}</label>
        </div>
      </div>
      <div class="row pt-2">
        <label class="col-3 text-right">Receipt Date:</label>
        <div class="col-7">
          <input
            class="form-control"
            type="date"
            v-model="model.delivery_date"
            name="receipt date"
            v-validate="{ required: true, date_between: dateRangeForValidation }"
          />
          <label
            class="error"
            v-if="errors.firstByRule('receipt date', 'required')"
          >The date field is required.</label>
          <label
            class="error"
            v-if="errors.firstByRule('receipt date', 'date_format')"
          >The date field is required.</label>
          <label
            class="error"
            v-if="errors.firstByRule('receipt date', 'date_between')"
          >The date field must be between {{ startDate }} and {{ endDate }}.</label>
        </div>
      </div>
      <div class="row pt-2">
        <p>This process receives your General Purchase Order. 
          No stock is added to the system using this method.</p>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" :disabled="loading" class="btn action-buttons" @click="goButtonHandler">Finish ></button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin } from "../../../../common/mixins";
// import { getSites, getSuppliersBySite } from '../../../api/calls';
import{ 
  formatDate, 
  displayNumber,
  formatViewDate,
  getFiscalYear,
  getFiscalYearDateRangeForValidation,
  getCurrentMonth,
  getMonthRangeForValidation,
} from '../../../../common/utitlities/helpers'

export default {
  name: "ReceiveGeneralOrder",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  props: {
    stockData: {
      type: Object,
      required: true,
    },
    currentOrder: {
      type: Object,
      required: true,
    }
  },
  data: () => ({
    model: {
      delivery_date: formatDate(new Date()),
    },
  }),
  computed: {
    supplierDetails() {
        return this.currentOrder.supplier_details || {};
    },
    supplierName() {
        return this.supplierDetails.trading_name || this.currentOrder.supplier_name;
    },
    color() {
      return this.stockData.color || {};
    },
    product() {
      return this.color.product || {};
    },
    productName() {
      return this.stockData.product_name || this.product.name;
    },
    startDate() {
      const startDate = this.isSuperAdmin ? getFiscalYear() : getCurrentMonth();
      return formatViewDate(startDate);
    },
    endDate() {
      const endDate = this.isSuperAdmin ? getFiscalYear('end') : getCurrentMonth('end');
      return formatViewDate(endDate);
    },
    dateRangeForValidation() {
      return this.isSuperAdmin ? getFiscalYearDateRangeForValidation() : getMonthRangeForValidation();
    },
  },
  watch: {
  },
  created() {
  },
  methods: {
    displayNumber,
    goButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          this.enableLoading();
          axios.put(`/api/current-orders/${this.currentOrder.id}/future-stocks/${this.stockData.id}/receive-general-order`, this.model)
            .then(({data}) => {
              this.$emit('received');
            })
            .catch(() => {
              console.log('could not receive order');
            })
            .finally(this.disableLoading);
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
