<template>
  <div>
    <div class="row">
      <label> Please Select the date for this Electronic Fund Transfer Remittance</label> 
    </div>
    <div class="row pt-2">
      <label class="col-4 text-right pr-3">Transaction Date</label>
      <div class="col-7">
        <input type="date" v-model="transactionDate" name="transaction date" v-validate="'required'">
        <label class="error">{{ errors.first('transaction date') }}</label>
      </div>
    </div>
  </div>  
</template>

<script>
export default {
  name: 'ElectronicFundTransfer',
  data: () => ({
    transactionDate: '',
  }),
  watch: {
    transactionDate(value) {
      return this.$emit('updated', { transaction_date: value });
    },
  },
};
</script>
