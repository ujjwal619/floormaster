<template>
  <div class="form-group row">
    <div class="col-lg-10">
      <div class="row pb-2">
        <!-- <label class="col-lg-4" style="text-align: right">Our Order Number:</label>
        <label class="col-lg-4" style="text-align: right">{{ model.order_number }}</label>-->
      </div>
      <div class="row pb-2">
        <label class="col-lg-4" style="text-align: right">Supplier's Reference:</label>
        <input class="col-lg-6 form-control" type="text" v-model="supplier_reference" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Page5",
  props: {
    data: {
      type: Object,
      default: () => ({}),
    },
  },
  data: () => ({
    supplier_reference: ""
  }),
  watch: {
    // data: {
    //   immediate: true,
    //   deep: true,
    //   handler(value) {
    //     if (value) {
    //       this.supplier_reference = value.supplier_reference;
    //     }
    //   },
    // },
    supplier_reference(value) {
      this.$emit("updated:values", "supplier_reference", value);
    }
  }
};
</script>
