<template>
  <modal title="Close Financial Year" @close="handleClose">
    <template slot="modal-body">
      <loading :loading="loading" />
      <label><b>
        FINANCIAL PERIOD: 
        {{ getViewFiscalYear() }}
        </b></label>
      <label class="mt-4">
          <b>
          Some time after the end of financial year you will complete any
          changes and record journal entries as instructed by your accountant.
          </b>
      </label>
      <label class="mt-4">
          <b>
          Finalise years need to 'Closed' so that no further changes can be
          made to General Ledger data of that Period.
          </b>
      </label>
      <label class="mt-4">
          <b>
          Asset, Liability and Equity closing balances are transfered to the opening
          balances of the next financial year. Any opening balances for that year will
          be overwritten.
          </b>
      </label>
      <label class="mt-4">
          <b>
          You should only close your financial year when your Trial Balance is 
          finalised and when no accout errors are reported by the financial 
          reporting processes.
          </b>
      </label>
    </template>
    <template slot="modal-footer">
      <button
        type="button"
        class="btn action-buttons"
        @click="handleCloseYear"
      >
        Close Year
      </button>
      <button
        type="button"
        class="btn action-buttons"
        @click="handleClose"
      >
        Cancel
      </button>
    </template>
  </modal>
</template>

<script>

  import Modal from '../../../common/components/Modal/Modal';
  import { getViewFiscalYear } from '../../../common/utitlities/helpers';
  import { LoadingMixin } from "../../../common/mixins";

  export default {
    name: 'ClosePeriodModal',
    mixins: [LoadingMixin],
    components: {
      Modal,
    },
    props: {
      site: {
        type: Object,
        required: true,
      },
    },
    methods: {
      getViewFiscalYear,
      handleClose() {
        this.$emit('close');
      },
      handleCloseYear() {
        //close financial year
        this.$emit('current-period')
        this.handleClose();
      },
    },
  }
</script>
