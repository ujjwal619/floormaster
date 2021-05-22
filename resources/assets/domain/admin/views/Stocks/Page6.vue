<template>
  <div>
    <div class="form-group row">
      <div class="col-lg-7 pb-2">
        <!-- <div class="row">
                    <label class="col-lg-4" style="text-align: right">Interim Order No:</label>
                    <label class="col-lg-7">Interim Order No:</label>
        </div>-->
        <div class="row">
          <label class="col-lg-4" style="text-align: right">Interim Order No:</label>
          <input class="col-lg-7 form-control" type="text" v-model="interim_order_number" />
        </div>
      </div>
      <div class="col-lg-5 pl-2 mx-auto my-auto">
        <label class="row">
          Quote the Purchase Order Number.
          If the Order has already been palced
          enter the Order Number quoted in the
          Interim Order No Box.
        </label>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 pt-3">Ready to print to printer</div>
    </div>
    <div class="row">
      <div class="col-lg-4">
        <button type="button" disabled class="btn action-buttons">Select Printer</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Page6",
  props: {
    data: {
      type: Object,
      default: () => ({}),
    },
  },
  data: () => ({
    interim_order_number: ""
  }),
  watch: {
    // data: {
    //   immediate: true,
    //   deep: true,
    //   handler(value) {
    //     if (value) {
    //       this.interim_order_number = value.interim_order_number;
    //     }
    //   },
    // },
    interim_order_number(value) {
      this.$emit("updated:values", "interim_order_number", value);
    }
  }
};
</script>
