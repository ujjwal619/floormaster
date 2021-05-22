<template>
  <modal title="Update Job" @close="handleClose">
    <template slot="modal-body">
      <div class="form-group row">
        <button
          v-if="hasPermission('job.access.invoice.jobs')" 
          type="button" 
          class="btn action-buttons" 
          @click="emit('modal:invoicing')"
        >Invoicing</button>
      </div>
      <div v-if="hasPermission('job.access.invoice.jobs')"  class="form-group row pt-3">
        <button 
          type="button" 
          class="btn action-buttons" 
          @click="emit('modal:receipts')"
        >Receipts</button>
      </div>
      <div v-if="hasPermission('job.access.allocate.mit')" class="form-group row pt-3">
        <button 
          type="button" 
          class="btn action-buttons" 
          @click="emit('modal:allocate-mit')"
        >
          Allocate MIT
        </button>
      </div>
      <div v-if="hasPermission('job.access.allocate.labour')" class="form-group row pt-3">
        <button  
          type="button" 
          class="btn action-buttons" 
          @click="emit('modal:allocate-labour')"
        >
          Allocate Labour
        </button>
      </div>
      <div v-if="hasPermission('job.access.retentions')" class="form-group row pt-3">
        <button type="button" class="btn action-buttons" @click="emit('modal:edit-retention')">
          Edit Retention
        </button>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../common/components/Modal/Modal";
import { CurrentUserMixin } from "../../../../common/mixins/index";

export default {
  name: "Update",
  mixins: [CurrentUserMixin],
  components: {
    Modal
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
