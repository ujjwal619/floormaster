<template>
   <modal title="Add To Cash Book" @close="handleClose" :is-small="true">
      <template slot="modal-body">
        <div class="row">
          <button type="button" class="btn action-buttons w-100" @click="emit('debit')">Debit</button>
        </div>
        <div class="row pt-2">
          <button type="button" class="btn action-buttons w-100" @click="emit('credit')">Credit</button>
        </div>
        <div class="row pt-2">
          <button type="button" class="btn action-buttons w-100" @click="handleClose">Cancel</button>
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
