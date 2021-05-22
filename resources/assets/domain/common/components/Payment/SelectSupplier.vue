<template>
  <div>
    <div class="row">
      <label class="col-4 text-right pr-3">Select Supplier</label>
      <div class="col-7">
        <drop-down
          placeholder="Search Supplier"
          v-model="supplier"
          :options="sites"
          v-validate="'required'"
          name="supplier"
          label="trading_name"
        />
        <label class="error">{{ errors.first('supplier') }}</label>
      </div>
    </div>
  </div>
</template>

<script>

import DropDown from "../DropDown/DropDown";

export default {
  name: 'SelectSupplier',
  components: {
    DropDown,
  },
  props: {
    siteId: {
      type: Number,
    },
    updatedSite: {
      type: Number,
    },
  },
  data: () => ({
    supplier: '',
    sites: [],
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
      axios.get(`/api/sites/${this.siteId || this.updatedSite}/suppliers`)
        .then(({ data }) => {
          this.sites = data.data;
        })
        .catch(error => console.log("could not fetch suppliers"));
    }
  }
}
</script>

