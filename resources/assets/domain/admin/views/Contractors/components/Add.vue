<template>
  <modal title="Update Order" @close="handleClose">
    <template slot="modal-body">
      <div class="form-group row">
        <button
          v-if="hasPermission('contractors.add.payment.due')"
          type="button"
          class="btn action-buttons"
          @click="emit('modal:add-payable')"
          :disabled="noLiabilityAC"
          :title="addPayableButtonTitle"
        >Add Payable Record</button>
      </div>
      <div class="form-group row pt-3">
        <button
          type="button"
          class="btn action-buttons"
          @click="emit('modal:add-contractor')"
        >Add Contractor</button>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import { CurrentUserMixin } from '../../../../common/mixins/index'

export default {
  name: "Add",
  mixins: [CurrentUserMixin],
  components: {
    Modal
  },
  props: {
    contractor: {
      type: Object,
      required: true
    },
  },
  data: () => ({
    noLiabilityAC: false,
    noCOSAC: false,
  }),
  computed: {
    addPayableButtonTitle() {
      let title = '';
      if (!this.contractor.contractor_liability_account) {
        this.noLiabilityAC = true;
        title = 'No liability account selected in contractor';
        return title;
      }
      if (!this.contractor.cost_of_sales_account) {
        this.noCOSAC = true;
        title = 'No COS account selected in contractor';
        return title;
      }

      return title;
    },
  },
  methods: {
    handleClose() {
      this.$emit("close", true);
    },
    emit(event) {
      this.$emit(event);
      this.$emit("close");
    }
  }
};
</script>
