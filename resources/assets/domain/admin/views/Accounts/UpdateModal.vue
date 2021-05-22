<template>
  <modal title="Chart Updates" @close="handleClose" :has-footer="false" :is-menu="true">
    <template slot="modal-body">
      <div class="menu-body">
          <button
            type="button"
            class="menu-button"
            @click="closePeriod"
        >
            Close Period
        </button>
        <button 
            type="button"
            class="menu-button"
            @click="rebuldChartBalances"
        >
            Rebuild Chart Balances
        </button>
        <button 
            type="button"
            class="menu-button"
            @click="handleClose"
        >
            Cancel
        </button>
      </div>
    </template>
  </modal>
</template>

<script>
  import Modal from '../../../common/components/Modal/Modal';

  export default {
    name: 'UpdateModal',
    components: {
      Modal,
    },
    methods: {
      handleClose() {
        this.$emit('close');
      },
      rebuldChartBalances() {
        this.$emit('rebuild');
        this.handleClose();
      },
      closePeriod() {
        this.$emit('close-period');
        this.handleClose();
      },
    },
  }
</script>

<style scoped>
    .menu-button {
        width: 164px;
        text-align: center;
        font-weight: bold;
        font-size: 12px;
    }
    .menu-body {
        display: flex;
        flex-direction: column;
        margin: -15px;
    }
</style>
