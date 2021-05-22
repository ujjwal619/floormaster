<template>
  <modal title="Product Reports" @close="handleClose">
    <template slot="modal-body">
      <div class="form-group m-form__group">
        <button
          type="button" 
          class="m-2" 
          @click="chooseReportType('FULL_PRICE_LIST_BY_SUPPLIER')"
        >Full Price-List by Supplier</button>
        <button 
          type="button" 
          class="m-2" 
          @click="chooseReportType('SHORT_PRICE_LIST')"
        >Short Price-List (No Costs)</button>
        <button 
          v-if="hasPermission('job.access.wip.report')"
          type="button" 
          class="m-2"
          @click="chooseReportType('SHORT_LIST_SQUARE_UNIT')"
        >Short List (Square Unit)</button>
        <button
          v-if="hasPermission('job.access.taking.reports')"
          type="button" 
          class="m-2"
          @click="chooseReportType('MATERIAL_ONLY')"
        >Material Only (Cost/Sell)</button>
        <button 
          type="button" 
          class="m-2"
          @click="chooseReportType('COLOURWAYS')"
        >Colourways</button>
        <button
          type="button" 
          class="m-2"
          @click="chooseReportType('FULL_PRICE_LIST_BY_RANGE')"
        >Full Price-List by Range</button>
        <button
          type="button" 
          class="m-2"
          @click="chooseReportType('SHORT_PRICE_LIST_BY_RANGE')"
        >Short Price-List by Range</button>
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
