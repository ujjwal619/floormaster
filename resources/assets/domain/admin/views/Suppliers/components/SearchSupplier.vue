<template>
  <modal title="Search Supplier" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <label>Store:</label>
        <drop-down
          :options="sites"
          v-model="selectedSite"
        />
      </div>
      <div class="row pt-2">
        <label>Supplier: </label>
        <drop-down
          placeholder="Search Supplier"
          v-model="supplierId"
          :options="suppliers"
          v-validate="'required'"
          name="suppliers"
          label="trading_name"
        />
        <label class="error">{{ errors.first('suppliers') }}</label>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="goButtonHandler">Go</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin } from '../../../../common/mixins'

export default {
  name: "SearchSupplier",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  props: {
    sites: {
      type: Array,
      required: true,
    },
    for: {
      type: String,
      default: '',
    },
  },
  data: () => ({
    supplierId: "",
    suppliers: [],
    selectedSite: '',
  }),
  watch: {
    selectedSite(value) {
      if (value) {
        this.fetchSuppliers(value);
      }
    },
  },
  methods: {
    fetchSuppliers(siteId) {
      this.enableLoading();
      axios
        .get(`/api/sites/${siteId}/suppliers`)
        .then(({ data }) => (this.suppliers = data.data))
        .catch(error =>
          this.$toastr("error", "Error fetching data", "Error!!")
        )
        .finally(() => this.disableLoading());
    },
    goButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          this.$emit('selected', this.supplierId);
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
