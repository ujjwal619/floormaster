<template>
  <modal title="Acting on Material Item" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <div class="col-6 row">
          <label class="col-6 text-right">Supplier:</label>
          <label class="col-6 pl-2">{{ material.supplier_name }}</label>
        </div>
      </div>
      <div class="row pt-2">
        <div class="col-6 row">
          <label class="col-6 text-right">Range:</label>
          <label class="col-6 pl-2">{{ material.product_name }}</label>
        </div>
      </div>
      <div class="row pt-2">
        <div class="col-6 row">
          <label class="col-6 text-right">Colour:</label>
          <label class="col-6 pl-2">{{ material.variant_name }}</label>
        </div>
        <div class="col-6 row">
          <label class="col-6 text-right">Current Stock:</label>
          <label class="col-6 pl-2">{{ stock.total_current_stock }}</label>
        </div>
      </div>
      <div class="row pt-2">
        <div class="col-6 row">
          <label class="col-6 text-right">Costed Qty:</label>
          <label class="col-6 pl-2">{{ material.quantity }}</label>
        </div>
        <div class="col-6 row">
          <label class="col-6 text-right">Future Stock:</label>
          <label class="col-6 pl-2">{{ stock.total_future_stock }}</label>
        </div>
      </div>
      <div class="row pt-2">
        <div class="col-6 row">
          <label class="col-6 text-right">Qty on Order:</label>
          <label class="col-6 pl-2">{{ onOrder }}</label>
        </div>
        <div class="col-6 row">
          <label class="col-6 text-right">Allocations:</label>
          <label class="col-6 pl-2">{{ stock.total_allocations }}</label>
        </div>
      </div>
      <div class="row pt-2">
        <div class="col-6 row">
          <label class="col-6 text-right">Qty on Allocated:</label>
          <label class="col-6 pl-2">{{ material.allocated }}</label>
        </div>
        <div class="col-6 row">
          <label class="col-6 text-right">Back Orders:</label>
          <label class="col-6 pl-2">{{ stock.total_back_orders }}</label>
        </div>
      </div>
      <div class="row pt-2">
        <div class="col-6 row">
          <label class="col-6 text-right">Qty on Act On:</label>
          <label class="col-6 pl-2">{{ actOnQuantity }}</label>
        </div>
        <div class="col-6 row pt-3">
          <label class="col-6 text-right">For Sale:</label>
          <label class="col-6 pl-2">
            {{ (Number(stock.current_stock_total_for_sell) + Number(stock.future_stock_total_for_sell)).toFixed(2) }}
          </label>
        </div>
      </div>
      <div class="row pt-3">
        <label>
          Choose either to Allocate Current or Future Stock or to Order more Stock.<br/>
          If there is not enough Stock you can Allocate what is available then
          run this process again to order the required balance.
        </label>
      </div>
      <div class="pt-2 d-flex justify-content-between align-items-center">
        <button type="button" class="btn action-buttons">Remove 'Act On' Status</button>
        <div class="d-flex align-items-center">
          <input type="checkbox">
          <label class="pl-2">Remind me of Colours 'To be Advised'</label>
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="goToStock">Go to Stock</button>
      <button type="button" class="btn action-buttons" @click="orderFutureStock">Order Stock</button>
      <button type="button" class="btn action-buttons" @click="allocate">Allocate Stock</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import { LoadingMixin } from '../../../../common/mixins/index';
import { getStockByColor } from "../../../api/calls";

export default {
  name: "ActOnMaterial",
  mixins: [LoadingMixin],
  components: {
    Modal
  },
  props: {
    material: {
      type: Object,
      required: true
    },
  },
  data() {
    return {
      onOrder: '',
      stock: {
        total_current_stock: 0,
        total_future_stock: 0,
        current_stock_total_for_sell: 0,
        future_stock_total_for_sell: 0,
        total_allocations: 0,
        total_back_orders: 0
      },
    };
  },
  created() {
    this.fetchStockData();
    this.onOrder = this.material.on_order;
  },
  computed: {
    actOnQuantity() {
      let num = Number(this.material.quantity) - Number(this.material.allocated);
      return num.toFixed(2);
    },
  },
  methods: {
    handleClose() {
      this.$emit('close');
    },
    fetchStockData() {
      this.enableLoading();
      getStockByColor(this.material.variant_id)
        .then(({ data }) => {
          this.stock = data.data.stock || {};
        })
        .catch(() => console.log('could not fetch stock data'))
        .finally(this.disableLoading);
    },
    allocate() {
      this.enableLoading()
      axios.patch(`/api/color/${this.material.variant_id}/enable-allocation-process`, { job_material_id: this.material.id })
        .then(() => {
          window.location.href = `/color/${this.material.variant_id}/stocks`;
        })
        .catch(() => {
          this.$toastr('error', 'Could not allocate stock.', 'Error!!')
          this.handleClose();
        })
        .finally(this.disableLoading);
    },
    goToStock() {
      window.location.href = `/color/${this.material.variant_id}/stocks`;
    },
    orderFutureStock() {
      this.$emit('orderfuturestock');
    },
  },
};
</script>
