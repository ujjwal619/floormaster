<template>
  <div class="form-group row">
    <div class="col-lg-8">
      <div class="row pb-2">
        <label class="col-lg-4" style="text-align: right">Quantity:</label>
        <div class="col-lg-8">
          <input class="form-control" key="quantity" type="number" v-model="model.quantity" @input="setInput('quantity',$event.target.value)" v-validate="'required|decimal:2'" name="quantity" />
          <label class="error">{{ errors.first('quantity') }}</label>
        </div>
      </div>
      <div class="row pb-2">
        <label class="col-lg-4" style="text-align: right">Unit: </label>
        <input @input="setInput('unit',$event.target.value)" class="col-lg-8 form-control" type="text" v-model="model.unit" />
      </div>
      <div class="row pb-2">
        <label class="col-lg-4" style="text-align: right">List Price $:</label>
        <div class="col-lg-8">
          <input @input="setInput('list_price',$event.target.value)" class="form-control" key="list" type="number" v-model="model.list_price" name="list price" v-validate="'required|decimal:2'" />
          <label class="error">{{ errors.first('list price') }}</label>
        </div>
      </div>
      <div class="row pb-2">
        <label class="col-lg-4" style="text-align: right">Discount %:</label>
        <input @input="setInput('discount',$event.target.value)" class="col-lg-8 form-control" type="number" v-model="model.discount" />
      </div>
      <div class="row pb-2">
        <label class="col-lg-4" style="text-align: right">Delivery $:</label>
        <input @input="setInput('delivery',$event.target.value)" class="col-lg-8 form-control" type="number" v-model="model.delivery" />
      </div>
      <div class="row pb-2">
        <label class="col-lg-4" style="text-align: right">Tax %:</label>
        <input @input="setInput('tax',$event.target.value)" class="col-lg-8 form-control" type="number" v-model="model.tax" />
      </div>
      <div class="row pb-2">
        <label class="col-lg-4" style="text-align: right">Levy %:</label>
        <input @input="setInput('levy',$event.target.value)" class="col-lg-8 form-control" type="number" v-model="model.levy" />
      </div>
      <div class="row pb-2">
        <label class="col-lg-4" style="text-align: right">Sell Price:</label>
        <input @input="setInput('sell_price',$event.target.value)" class="col-lg-8 form-control" type="text" v-model="model.sell_price" />
      </div>
      <br />
      <div class="row pb-2">
        <label class="col-lg-4" style="text-align: right">Source:</label>
        <label class="col-lg-3">Price-List</label>
      </div>
    </div>
    <div class="col-lg-4 pl-3 mx-auto my-auto">
      <label>
        Default values are drawn from
        the newest stock item of this
        Product or from the Price-List
        if there is no Stock.
      </label>
    </div>
  </div>
</template>

<script>
export default {
  name: "Page1",
  components: {},
  props: {
    data: {
      type: Object,
      default: () => ({})
    },
    stockData: {
      type: Object,
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
  },
  data: () => ({
    model: {}
  }),
  watch: {
    data: {
      immediate: true,
      deep: true,
      handler(value) {
        if (value) {
          this.model = value;
        }
      },
    },
  },
  methods: {
    setInput(field, value) {
      console.log('ho ho', value);
      const oldData = Object.assign({}, this.stockData.values);
      oldData[field] = value;
      this.$emit("updated:stock-data", oldData);
    },
  },
};
</script>
