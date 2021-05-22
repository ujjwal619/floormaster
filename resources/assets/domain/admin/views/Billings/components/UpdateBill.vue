<template>
   <modal title="Update Bill" @close="handleClose" :is-small="true">
      <template slot="modal-body">
        <div class="row">
          <button type="button" class="btn action-buttons" @click="emit('invoice-expense')">Add Invoice Expense</button>
        </div>
        <div class="row pt-2">
          <button type="button" class="btn action-buttons" @click="emit('retention')">Edit Retention</button>
        </div>
        <div class="row pt-2">
          <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
        </div>
      </template>
   </modal>
</template>

<script>

import PortletContent from '../../../../common/components/Portlets/Content/PortletContent';
import Modal from '../../../../common/components/Modal/Modal';

export default {
  name: 'UpdateBill',
  components: {
    PortletContent,
    Modal,
  },
  methods: {
    handleClose() {
      this.$emit('close');
    },
    emit(event) {
      this.$emit(event);
      this.handleClose();
    },
  },

};
</script>
