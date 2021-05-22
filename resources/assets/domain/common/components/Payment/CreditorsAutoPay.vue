<template>
  <div>
    <div class="row">
      <label class="col-4 text-right pr-3">Pay Up-To</label>
      <div class="col-7">
        <input type="date" v-model="invoiceDate" name="pay up to" v-validate="'required'" class="form-control">
        <label>(Invoice Date)</label>
        <label class="error">{{ errors.first('pay up to') }}</label>
      </div>
    </div>
  </div>  
</template>

<script>
export default {
  name: 'CreditorsAutoPay',
  data: () => ({
    invoiceDate: '',
  }),
  watch: {
    invoiceDate(value) {
      return this.$emit('updated', { invoice_date: value });
    },
  },
};
</script>
