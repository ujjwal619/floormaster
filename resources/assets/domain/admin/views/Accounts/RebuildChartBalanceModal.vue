<template>
  <modal title="Rebuild Chart of Accounts Balances" @close="handleClose">
    <template slot="modal-body">
      <loading :loading="loading" />
      <label><b>{{ getViewFiscalYear() }}</b></label>
      <label class="mt-4">
          <b>
          Due to hardware, software or power failure it is possible that the<br>
          current balances in your Chart of Accounts will contain errors.<br>
          This process rebuilds the balances from the General Ledger<br>
          transactions records.
          </b>
      </label>
      <label class="mt-4">
          <b>
          FLOORmanager requires exclusive access for this process so<br>
          ensure that all other users stay out of FLOORmanager.
          </b>
      </label>
    </template>
    <template slot="modal-footer">
      <button
        type="button"
        class="btn action-buttons"
        @click="handleSave"
      >
        Go >
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
    name: 'RebuildChartBalanceModal',
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
      handleSave() {
        this.$emit('saved')
      },
    },
  }
</script>
