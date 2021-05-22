<template>
  <modal title="Select Account" @close="handleClose">
    <loading :loading="loading" />
    <template slot="modal-body">
      <div class="row">
        <label>Account:</label>
        <drop-down
          :options="accounts"
          :default-selected="defaultAccount"
          placeholder="Select Account"
          v-model="selectedAccount"
        />
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="goButtonHandler">Go</button>
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../components/Modal/Modal";
import DropDown from "../components/DropDown/DropDown";
import { LoadingMixin } from '../../common/mixins'

export default {
  name: "Account Pick",
  mixins: [LoadingMixin],
  components: {
    DropDown,
    Modal
  },
  props: {
    accounts: {
      type: Array,
      required: true,
    },
    defaultAccount: {
      type: Object,
      default: ({})
    },
  },
  data: () => ({
    selectedAccount: '',
  }),
  methods: {
    goButtonHandler() {
      this.validate().then(valid => {
        if (valid) {
          this.$emit('selected', this.selectedAccount);
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
