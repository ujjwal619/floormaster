<template>
  <modal :title="title" @close="handleClose">
    <template slot="modal-body">
      <div class="col-lg-8">
        <div class="row">
          <span class="h6">Select Tax Payee</span>
        </div>
        <drop-down :options="suppliers" v-model="supplier" label="trading_name"/>
      </div>
      <div class="col-lg-8">
        <span class="h6">Select Tax Liability Payee</span>
        <drop-down :options="options" v-model="account"/>
      </div>
    </template>
    <template slot="modal-footer">
      <button
        type="button"
        class="btn action-buttons"
        :disabled="!supplier || !account"
        @click="selectAccountHandler"
      >OK</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import DropDown from "../../../../common/components/DropDown/DropDown";

export default {
  name: "SelectSupplierAccount",
  components: {
    Modal,
    DropDown
  },
  props: {
    title: {
      type: String,
      required: true
    },
    type: {
      type: String,
      required: true
    },
    options: {
      type: Array,
      required: true
    },
    suppliers: {
      type: Array,
      required: true
    }
  },
  data: () => ({
    supplier: null,
    account: null
  }),
  computed: {
    getSelectedOption() {
      if (this.supplier && this.account) {
        const supplier = this.suppliers.find(
          supplierOption => supplierOption.id === this.supplier
        );
        const account = this.options.find(option => option.id === this.account);
        return {
          supplier: supplier,
          account: account
        };
      }
    }
  },
  methods: {
    handleClose() {
      this.$emit("close", true);
    },
    selectAccountHandler() {
      this.$emit("selected", {
        type: this.type,
        selectedOption: this.getSelectedOption
      });
      this.handleClose();
    }
  }
};
</script>

