<template>

  <modal title="Search Supplier" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
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
          />
          <label class="error">{{ errors.first('supplier') }}</label>
        </div>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="goButtonHandler">Go</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>

import DropDown from "../../../../common/components/DropDown/DropDown";
import { LoadingMixin } from "../../../../common/mixins";
import Modal from '../../../../common/components/Modal/Modal'

export default {
  name: 'SelectCentralBilling',
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  props: {
    currentSupplier: {
      type: Object,
      required: true,
    },
  },
  data: () => ({
    supplier: '',
    suppliers: [],
  }),
  mounted() {
    this.fetchSuppliers();
  },
  methods: {
    fetchSuppliers() {
      axios.get(`/api/sites/${this.currentSupplier.site_id}/suppliers`)
        .then(({ data }) => {
          let suppliers = data.data;
          this.suppliers = suppliers.filter(supplier => supplier.id !== this.currentSupplier.id)
        })
        .catch(error => console.log("could not fetch suppliers"));
    },
    findSupplier(id) {
      return this.suppliers.find(supplier => supplier.id === id) || {};
    },
    goButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          let supplier = this.findSupplier(this.supplier);
          this.$emit('selected', { id: supplier.id, trading_name: supplier.trading_name });
          this.handleClose();
        }
      });
    },
    validate() {
      return this.$validator.validate();
    },
    handleClose() {
      this.$emit("close");
    }
  },

}
</script>

