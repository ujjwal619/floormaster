<template>
  <div>
    <div class="row">
      <label class="col-4 text-right pr-3">Select Supplier</label>
      <div class="col-7">
        <drop-down
          placeholder="Search Supplier"
          v-model="supplier"
          :options="suppliers"
          v-validate="'required'"
          name="supplier"
          label="trading_name"
          :default-selected="defaultSupplier"
        />
        <label class="error">{{ errors.first('supplier') }}</label>
      </div>
    </div>
  </div>
</template>

<script>

import DropDown from "../../../../common/components/DropDown/DropDown";

export default {
  name: 'SelectSupplier',
  components: {
    DropDown,
  },
  props: {
    siteId: {
      type: Number,
      required: true,
    },
    currentSupplier: {
      type: Number,
      required: true,
    },
  },
  data: () => ({
    supplier: '',
    suppliers: [],
    defaultSupplier: {}
  }),
  watch: {
    supplier(value) {
      return this.$emit('updated', { supplier_id: value });
    },
  },
  mounted() {
    this.fetchSuppliers();
  },
  methods: {
    fetchSuppliers() {
      axios.get(`/api/sites/${this.siteId}/suppliers`)
        .then(({ data }) => {
          this.defaultSupplier = data.data.find(supplier => supplier.id === this.currentSupplier) || {}
          this.suppliers = data.data;
        })
        .catch(error => console.log("could not fetch suppliers"));
    }
  }
}
</script>

