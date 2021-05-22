<template>
  <div class="form-group row">
    <div class="col-lg-10">
      <div class="row pb-2">
        <label class="col-lg-4" style="text-align: right">Name:</label>
        <input class="col-lg-8 form-control" type="text" v-model="delivery_address.name" />
      </div>
      <div class="row pb-2">
        <label class="col-lg-4" style="text-align: right">Street:</label>
        <input class="col-lg-8 form-control" type="text" v-model="delivery_address.street" />
      </div>
      <div class="row pb-2">
        <label class="col-lg-4" style="text-align: right">Town:</label>
        <input class="col-lg-8 form-control" type="text" v-model="delivery_address.town" />
      </div>
      <div class="row pb-2">
        <label class="col-lg-4" style="text-align: right">State/Code:</label>
        <input class="col-lg-2 form-control" type="text" v-model="delivery_address.state" />
        <input class="col-lg-2 form-control" type="text" v-model="delivery_address.code" />
      </div>
      <div class="row pb-2">
        <label class="col-lg-4" style="text-align: right">Phone:</label>
        <input class="col-lg-8 form-control" type="text" v-model="delivery_address.phone" />
      </div>
      <div class="row pb-2">
        <label class="col-lg-4" style="text-align: right">Fax:</label>
        <input class="col-lg-8 form-control" type="text" v-model="delivery_address.fax" />
      </div>
      <div class="row pb-2">
        <label class="col-lg-4" style="text-align: right">Notes:</label>
        <textarea class="col-lg-8" v-model="delivery_address.notes" cols="8" rows="5"></textarea>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Page4",
  props: {
    data: {
      type: Object,
      default: () => ({})
    },
    supplier: {
      type: Object,
      default: () => ({})
    },
  },
  data: () => ({
    delivery_address: {}
  }),
  computed: {
    site() {
      return this.supplier.site || {};
    },
  },
  watch: {
    // data: {
    //   immediate: true,
    //   deep: true,
    //   handler(value) {
    //     if (value) {
    //       this.delivery_address = value.delivery_address;
    //     }
    //   },
    // },
    delivery_address(value) {
      this.$emit("updated:values", "delivery_address", value);
    }
  },
  created() {
    this.delivery_address = this.site.delivery_address
      ? JSON.parse(this.site.delivery_address)
      : {};
  }
};
</script>
