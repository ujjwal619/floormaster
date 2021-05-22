<template>
  <modal title="Job Reports" @close="handleClose">
    <template slot="modal-body">
      <div class="form-group m-form__group">
        <button
          v-if="hasPermission('job.access.sales.report')" 
          type="button" 
          class="m-2" 
          @click="chooseReportType('BILLING')"
        >Billing</button>
        <button 
          v-if="hasPermission('job.access.commissions')"
          type="button" 
          class="m-2" 
          @click="chooseReportType('COMMISSION')"
        >Commission</button>
        <button 
          v-if="hasPermission('job.access.wip.report')"
          type="button" 
          class="m-2" 
          @click="chooseReportType('WIP')"
        >Work In Progress</button>
        <button type="button" class="m-2">Aged Debtors</button>
        <button type="button" class="m-2">Sales</button>
        <button
          v-if="hasPermission('job.access.taking.reports')"
          type="button" 
          class="m-2"
          @click="chooseReportType('TAKING')"
        >Takings</button>
        <button 
          v-if="hasPermission('job.access.mit.reports')"
          type="button" 
          class="m-2"
          @click="chooseReportType('MIT')"
        >Money Held In Trust</button>
        <button
          type="button" 
          class="m-2"
          @click="chooseReportType('JOB_COSTS')"
        >Jobs Costs Report</button>
        <button
          type="button" 
          class="m-2"
          @click="chooseReportType('UNDER_INVOICED')"
        >Under Invoiced Report</button>
      </div>
    </template>
    <template slot="modal-footer">
      <button type="button" class="btn action-buttons" @click="handleClose">Cancel</button>
    </template>
  </modal>
</template>

<script>
import Modal from "../../../../../common/components/Modal/Modal";
import { CurrentUserMixin } from '../../../../../common/mixins/index'

export default {
  name: "ChooseJobReportType",
  mixins: [CurrentUserMixin],
  components: {
    Modal,
  },
  data: () => ({
  }),
  methods: {
    handleClose() {
      this.$emit("close");
    },
    chooseReportType(type) {
      this.$emit('choosenReportType', type);
      this.handleClose();
    },
  }
};
</script>
