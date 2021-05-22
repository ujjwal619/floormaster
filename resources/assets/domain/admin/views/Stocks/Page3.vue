<template>
  <div>
    <div class="form-group row">
      <div class="col-lg-8">
        <div class="row pb-2">
          <label class="col-lg-4" style="text-align: right">Sales Contact:</label>
          <label class="col-lg-4">{{ supplier.sales_detail ? supplier.sales_detail.contact : '' }}</label>
        </div>
        <div class="row pb-2">
          <label class="col-lg-4" style="text-align: right">Sales Phone:</label>
          <label class="col-lg-4">{{ supplier.sales_detail ? supplier.sales_detail.phone : '' }}</label>
        </div>
        <div class="row pb-2">
          <label class="col-lg-4" style="text-align: right">Placed With:</label>
          <input class="col-lg-6 form-control" type="text" v-model="supplier_details.placed_with" />
        </div>
      </div>
      <div class="col-lg-10 pb-2 pt-3">
        <label class="row">
          Add as many as 10 items to this Order.
          You must enter (or confirm) the name
          of the person that you are placing this
          Order with. Activate the Next > button
          when all Items have been added.
        </label>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 pt-3 fit-content">
        <div class="col-lg-4 text-bold">Order Items:</div>
      </div>
      <div class="col-lg-12 order-box p-2">
        <div v-for="(stock, index) in list" :key="index">
          <label class="background-blue">
            {{ stock.quantity }} &nbsp;
            {{ stock.unit }} &nbsp;
            {{ product.name }},&nbsp;
            {{ color.name }} &nbsp;@
            <template
              v-if="stock.list_price"
            >${{ stock.list_price }}</template>&nbsp;
            <template v-if="stock.discount">minus {{ stock.discount }}%</template>
            <template v-if="stock.tax">plus {{ stock.tax }}% GST</template>.
          </label>
        </div>
      </div>
      <div class="row mt-2">
        <button type="button" class="btn action-buttons" @click="addItemsToOrder">Add Items to Order</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Page3",
  components: {},
  props: {
    stockList: {
      type: Array,
      required: true
    },
    supplier: {
      type: Object,
      required: true
    },
    product: {
      type: Object,
      required: true
    },
    color: {
      type: Object,
      required: true
    },
    data: {
      type: Object,
      default: () => ({}),
    },
  },
  computed: {
    list() {
      return this.stockList;
    }
  },
  data: () => ({
    supplier_details: {
      placed_with: ""
    }
  }),
  watch: {
    data: {
      immediate: true,
      deep: true,
      handler(value) {
        if (value) {
          this.supplier_details.placed_with = value.supplier_details ? value.supplier_details.placed_with : '';
        }
      },
    },
    supplier_details: {
      deep: true,
      handler(value) {
        this.$emit("updated:values", "supplier_details", {
          ...value,
        });
      }
    }
  },
  methods: {
    addItemsToOrder() {
      this.$emit("add:new-item");
    }
  }
};
</script>

<style>
.order-box {
  border: 1px solid black;
  background-color: white;
}
.background-blue {
  background-color: blue;
  color: white;
}
.fit-content {
  width: fit-content;
}
</style>
