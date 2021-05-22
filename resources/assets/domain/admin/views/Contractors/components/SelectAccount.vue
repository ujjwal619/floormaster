<template>
  <modal :title="`${title} Account Required`" @close="handleClose">
    <template slot="modal-body">
      <div class="col-lg-8">
        <div class="row">
          <span class="h6">Select Account</span>
        </div>
        <drop-down 
          :options="options"
          :allow-empty="allowEmpty" 
          v-model="account_id"
        />
      </div>
    </template>
    <template slot="modal-footer">
      <button
        type="button"
        :disabled="disableOkButton"
        class="btn action-buttons"
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
  name: "SelectAccount",
  components: {
    Modal,
    DropDown
  },
  props: {
    type: {
      type: String,
      required: true
    },
    title: {
      type: String,
      required: true
    },
    options: {
      type: Array,
      required: true
    },
    allowEmpty: {
      type: Boolean,
      required: false
    },
  },
  data: () => ({
    account_id: null
  }),
  computed: {
    selectedAccountOption() {
      if (this.account_id) {
        return this.options.find(option => option.id === this.account_id);
      }
      return "";
    },
    disableOkButton() {
      return this.allowEmpty ? !this.allowEmpty : !this.account_id;
    },
  },
  methods: {
    handleClose() {
      this.$emit("close", true);
    },
    selectAccountHandler() {
      this.$emit("selected", {
        type: this.type,
        selectedOption: this.selectedAccountOption
      });
      this.handleClose();
    }
  }
};
</script>

